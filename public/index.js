/**
 * Show the graph on the page after fetching data from the API
 */
let drawGraph = async () => {
	const params = new URLSearchParams(window.location.search);
	const max_hours = parseInt(params.get("maxhours")) || 24; //Default to 24 hours
	document.querySelector("#waterLevelHours").innerText = max_hours;
	document.querySelector("#hoursRange").value = max_hours;
	console.log("Drawing graph with maximum hours of: ", max_hours);

	let data = (await (await fetch("/getdata", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			hours_back: max_hours
		})
	})).json()).arr;
	data = data.map((row) => {
		row[0] = new Date(row[0]); //Time in hours from now
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
		width: 700,
		height: 500,
		hAxis: {
			title: "Time",
			slantedText:true,
			slantedTextAngle: 45
		},
		vAxis: {
			title: "Water Level",
			minValue: 0,
			maxValue: 14
		},
		legend: {
			position: "bottom"
		},
		trendlines: {
			0: {
				type: 'linear',
				visibleInLegend: true,
				showR2: true,
			}
		}
	};

	let chart = new google.visualization.ScatterChart(document.getElementById('chartContainer'));
	chart.draw(tableData, options);
}

/**
 * Set the current tree water level
 * @param {number} level Percentage water level
 */
const setGraphic = (level) => {
	console.log("Current tree percent full: ", level.currentLevel);
	document.querySelector(":root").style.setProperty("--percentfull", level.currentLevel/100);
	document.querySelector("#currLevel").innerText = `${level.currentLevel}% full`;
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
