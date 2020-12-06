const tabs = ["#home", "#graph", "#filling", "#settings"]; //Window tabs


/**
 * Show the graph on the page after fetching data from the API
 */
let drawGraph = async () => {
	const params = new URLSearchParams(window.location.search);
	console.log(params.get("timeStart"));
	const tStart = new Date(params.get("timeStart") || new Date()); //Get date or current time
	const tEnd = new Date(params.get("timeEnd") || new Date());
	document.querySelector("#waterLevelTime").innerText = `${tStart.toLocaleString()} until ${tEnd.toLocaleString()} (about ${Math.round(((tEnd-tStart)/3600000))} hours)`;
	document.querySelector("#timeStart").value = tStart.toISOString().slice(0, -8);
	document.querySelector("#timeEnd").value = tEnd.toISOString().slice(0, -8);
	console.log(`Drawing graph with range of time start ${tStart} to time end ${tEnd}`);

	if (isNaN(tStart.valueOf()) || isNaN(tEnd.valueOf())) return; //Exit if invalid dates

	let data = (await (await fetch("/getdata", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			tStart: tStart.valueOf(),
			tEnd: tEnd.valueOf()
		})
	})).json()).arr;

	data = data.map((row) => {
		row[0] = (row[0] - tStart.valueOf())/3600000; //new Date(row[0]); //Time in hours from now
		return row;
	});

	if (data.length < 1) return; //Don't render graph if no data to show

	console.log("Drawing graph with data: ", data);

	let tableData = google.visualization.arrayToDataTable([
		["Timestamp", "Raw Level"],
		...data
	]);

	let options = {
		title: "Time vs Tree Water Level",
		width: window.innerWidth-35,
		height: 500,
		hAxis: {
			title: "Time",
			slantedText: true,
			slantedTextAngle: 45
		},
		vAxis: {
			title: "Water Level",
			format: "#",
			minValue: 0,
			maxValue: 14,
			gridlines: {
				count: 14
			}
		},
		legend: {
			alignment: "center",
			position: "top",
			maxLines: "1"
		},
		trendlines: {
			0: {
				type: 'linear',
				visibleInLegend: true,
				showR2: true
			}
		},
		chartArea: {
			width: "91%",
			height: "60%",
			top: "9%",
			left: "8%",
			right: "1%",
			bottom: "31%"
		},

	};

	let chart = new google.visualization.ScatterChart(document.getElementById('chartContainer'));

	google.visualization.events.addListener(chart, "ready", () => {
		console.log("Chart loaded");
		let eq = $('text[text-anchor="start"][fill="#222222"]').text();
		eq = eq.slice(eq.indexOf("=")+1, eq.indexOf("..."));
		let m = parseFloat(eq.slice(0, eq.indexOf("*")));
		let b = parseFloat(eq.slice(eq.indexOf("+")+1));
		const MIN_LEVEL = 3; const MAX_LEVEL = 12;
		let nextFilling = new Date( tEnd.valueOf() + 3600000*((MAX_LEVEL - MIN_LEVEL)/2 - b)/m );
		document.querySelector("#equationRes").innerHTML = nextFilling.toLocaleString();
		console.log(m, b);
	});

	chart.draw(tableData, options);
}

/**
 * Set the current tree water level
 * @param {number} level Percentage water level
 */
const setGraphic = (level) => {
	console.log("Current tree percent full: ", level.currentLevel);
	document.querySelector(":root").style.setProperty("--percentfull", level.currentLevel/100);
	document.querySelector("#currLevel").innerText = `${Math.round(level.currentLevel)}% full`;
	document.querySelector("#currLevel").classList.remove("text-warning");
	if (level.currentLevel < 35) {
		document.querySelector("#currLevel").classList.add("text-danger");
	} else if (level.currentLevel < 67) {
		document.querySelector("#currLevel").classList.add("text-warning");
	} else {
		document.querySelector("#currLevel").classList.add("text-success");
	}
}

/**
 * Show the settings
 * @param {Object} settings Settings for the tree measuring code (min/max)
 */
const showSettings = (settings) => {
	console.log("Settings: ", settings);
	if (!settings) return;
	document.querySelector("#minRangeTxt").innerText = settings.min;
	document.querySelector("#minRange").value = settings.min;
	document.querySelector("#maxRangeTxt").innerText = settings.max;
	document.querySelector("#maxRange").value = settings.max;
	document.querySelector("#emailInput").value = settings.email;
}

/**
 * Show the filling mode status
 * @param {boolean} status Filling status
 */
const showFillingMode = (status) => {
	console.log("Filling status: ", status);
	document.querySelector("#fillingFormBtn").disabled = status; //Disable button if running/NC
	if (status === undefined) return;
	document.querySelector("#fillingMsg").classList.remove("text-warning");
	document.querySelector("#fillingMsg").classList.toggle("text-success", status);
	document.querySelector("#fillingMsg").classList.toggle("text-danger", !status);
	document.querySelector("#fillingMsg").innerText = status ? "Running" : "Not running";
}



/**
 * Update a range label with the new range value
 * @param {string} id ID of the range element
 */
const updateRangeValue = (id) => {
	document.querySelector(`#${id}Txt`).innerText = document.querySelector(`#${id}`).value;
}

/**
 * Event handler for settings form
 */
const onSettingsForm = (ev) => {
	ev.preventDefault();
	fetch("/setsettings", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			min: document.querySelector("#minRange").value,
			max: document.querySelector("#maxRange").value,
			email: document.querySelector("#emailInput").value
		})
	})
		.then(res => res.json())
		.then(res => {
			if (res.success) {
				alert("Successfully updated settings");
				window.location.reload();
			} else {
				alert("Invalid values. Please ensure that max is greater than min.");
			}
		})
		.catch(err => {
			alert("Unexpected error while submitting settings. Server may be offline.");
			console.log(err);
		});
}

/**
 * Event handler for shutdown form
 */
const onShutdownForm = (ev) => {
	ev.preventDefault();
	fetch("/shutdown", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			pswd: document.querySelector("#password").value,
		})
	})
		.then(res => res.json())
		.then(res => {
			if (res.success) {
				alert("Successfully initiated shutdown");
			} else {
				alert("Incorrect password. Please try again.");
			}
		})
		.catch(err => {
			alert("Unexpected error while submitting shutdown. Server may be offline.");
			console.log(err);
		});
}

/**
 * Event handler for shutdown form
 */
const onFillingForm = (ev) => {
	ev.preventDefault();
	fetch("/fillingmode", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			timeout: document.querySelector("#fillingTimeout").value
		})
	})
		.then(res => res.json())
		.then(res => {
			if (res.success) {
				alert("Successfully initiated filling mode");
			} else {
				alert("Incorrect value or internal error. Please try again.");
			}
			window.location.reload();
		})
		.catch(err => {
			alert("Unexpected error while starting filling mode. Server may be offline.");
			console.log(err);
		});
}


//Main page-load logic
window.onload = () => {
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawGraph);
	fetch("/getcurrent", { method: "POST" })
		.then(res => res.json())
		.then(res => setGraphic(res));

	fetch("/getsettings", { method: "POST" })
		.then(res => res.json())
		.then(res => showSettings(res.settings));

	fetch("/getfillingmode", { method: "POST" })
		.then(res => res.json())
		.then(res => showFillingMode(res.status));

	document.querySelector("#minRange").oninput = () => updateRangeValue("minRange");
	document.querySelector("#maxRange").oninput = () => updateRangeValue("maxRange");

	document.querySelector("#settingsForm").onsubmit = onSettingsForm;
	document.querySelector("#shutdownForm").onsubmit = onShutdownForm;
	document.querySelector("#fillingForm").onsubmit = onFillingForm;

	//Attempt to register service worker
	if ("serviceWorker" in navigator) {
		navigator.serviceWorker.register("/sw.js").then((reg) => {
			console.log("Successfully registered service worker");
		}, (err) => {
			console.log("Error while registering service worker: ", err);
		});
	}

	window.onhashchange = tabChange; //Bind hashchange to tabChange method
	tabChange(); //Change tab if specified in hash
}

/**
 * Change to the tab specified in window.location.hash
 */
const tabChange = () => {
	console.log(tabs.indexOf(window.location.hash));
	if (tabs.indexOf(window.location.hash) < 0) return; //Exit if hash is not a tab name
	for (let tab of tabs) {
		if (tab != window.location.hash) {
			$(tab + "Tab").removeClass("active");
			$(tab).hide();
		} else {
			$(tab + "Tab").addClass("active");
			$(tab).show();
			$(tab).tab("show");
		}
	}
}


//PWA installation
window.onbeforeinstallprompt = (ev) => {
	window.deferredPrompt = ev;
	console.log("Add deferred prompt", window.deferredPrompt);
	document.querySelector("#installBtnCtn").classList.toggle("d-none", false);
}

document.querySelector("#installBtn").onclick = () => {
	console.log("Btn clicked");
	if (!window.deferredPrompt) {
		return;
	}
	window.deferredPrompt.prompt(); //Show user prompt
	window.deferredPrompt.userChoice.then((res) => {
		window.deferredPrompt = null; //Rule out possibility of running twice
		document.querySelector("#installBtnCtn").classList.toggle("d-none", true);
	});
}



