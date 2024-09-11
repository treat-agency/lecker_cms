
<script>
'use strict';

$(document).ready(function() {

// settings and constants

const microphoneIcon = '<i class="fas fa-microphone"></i>';
const recordIcon = '<i class="fas fa-record-vinyl"></i>';

const heygen_API = {
  apiKey: '<?= HEYGEN_API ?>',
  serverUrl: 'https://api.heygen.com',
};

const statusElement = document.querySelector('#status');
const apiKey = heygen_API.apiKey;
const SERVER_URL = heygen_API.serverUrl;
const HOST = '<?= site_url() ?>';

if (apiKey === 'YourApiKey' || SERVER_URL === '') {
  alert('Please enter your API key and server URL in the api.json file');
}

let sessionInfo = null;
let peerConnection = null;

// Create a new WebRTC session when clicking the "New" button
async function createNewSession() {
  console.log('Creating new session...');

  const avatar = '';
  // const voice = voiceID.value;
  const voice = 'bfc6d0242de24106a104339f0618b68d';

  // call the new interface to get the server's offer SDP and ICE server to create a new RTCPeerConnection
  sessionInfo = await newSession('high', avatar, voice);
  const { sdp: serverSdp, ice_servers2: iceServers } = sessionInfo;

  // Create a new RTCPeerConnection
  peerConnection = new RTCPeerConnection({ iceServers: iceServers });

  // When audio and video streams are received, display them in the video element
  peerConnection.ontrack = (event) => {
    console.log('Received the track');
    if (event.track.kind === 'audio' || event.track.kind === 'video') {
      mediaElement.srcObject = event.streams[0];
    }
  };

  // When receiving a message, display it in the status element
  peerConnection.ondatachannel = (event) => {
    const dataChannel = event.channel;
    dataChannel.onmessage = onMessage;
  };

  // Set server's SDP as remote description
  const remoteDescription = new RTCSessionDescription(serverSdp);
  await peerConnection.setRemoteDescription(remoteDescription);

  console.log('Session creation completed');
  console.log('Now.You can click the start button to start the stream');

  $('#newBtn').hide();
  $('#startBtn').show();

}

// new session
async function newSession(quality, avatar_name, voice_id) {
  const response = await fetch(`${SERVER_URL}/v1/streaming.new`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Api-Key': apiKey,
    },
    body: JSON.stringify({
      quality,
      avatar_name,
      voice: {
        voice_id: voice_id,
      },
    }),
  });
  if (response.status === 500) {
    console.error('Server error');
    updateStatus('Server Error. Please ask the staff if the service has been turned on',
    );

    throw new Error('Server error');
  } else {
    const data = await response.json();
    console.log(data.data);
    return data.data;
  }
}

// start the session
async function startSession(session_id, sdp) {
  const response = await fetch(`${SERVER_URL}/v1/streaming.start`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Api-Key': apiKey,
    },
    body: JSON.stringify({ session_id, sdp }),
  });
  if (response.status === 500) {
    console.error('Server error');
    updateStatus(
      statusElement,
      'Server Error. Please ask the staff if the service has been turned on',
    );
    throw new Error('Server error');
  } else {
    const data = await response.json();
    return data.data;
  }
}

// submit the ICE candidate
async function handleICE(session_id, candidate) {
  const response = await fetch(`${SERVER_URL}/v1/streaming.ice`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Api-Key': apiKey,
    },
    body: JSON.stringify({ session_id, candidate }),
  });
  if (response.status === 500) {
    console.error('Server error');
    updateStatus(
      statusElement,
      'Server Error. Please ask the staff if the service has been turned on',
    );
    throw new Error('Server error');
  } else {
    const data = await response.json();
    return data;
  }
}

// when clicking the "Close" button, close the connection
async function closeConnectionHandler() {
  if (!sessionInfo) {
    updateStatus('Please create a connection first');
    return;
  }

  renderID++;
  // hideElement(canvasElement);
  // hideElement(bgCheckboxWrap);
  mediaCanPlay = false;

  updateStatus('Closing connection... please wait');
  try {
    // Close local connection
    peerConnection.close();
    // Call the close interface
    const resp = await stopSession(sessionInfo.session_id);

    console.log(resp);
  } catch (err) {
    console.error('Failed to close the connection:', err);
  }
  updateStatus('Connection closed successfully');

  openAndCloseControl(false);

}

document.querySelector('#newBtn').addEventListener('click', createNewSession);
document.querySelector('#startBtn').addEventListener('click', startAndDisplaySession);
document.querySelector('#repeatBtn').addEventListener('click', repeatHandler);
document.querySelector('#closeBtn').addEventListener('click', closeConnectionHandler);
document.querySelector('#talkBtn').addEventListener('click', talkHandler);




// Start session and display audio and video when clicking the "Start" button
async function startAndDisplaySession() {
  if (!sessionInfo) {
    updateStatus('Please create a connection first');
    return;
  }

  updateStatus('Starting session... please wait');

  // Create and set local SDP description
  const localDescription = await peerConnection.createAnswer();
  await peerConnection.setLocalDescription(localDescription);

  // When ICE candidate is available, send to the server
  peerConnection.onicecandidate = ({ candidate }) => {
    console.log('Received ICE candidate:', candidate);
    if (candidate) {
      handleICE(sessionInfo.session_id, candidate.toJSON());
    }
  };

  // When ICE connection state changes, display the new state
  peerConnection.oniceconnectionstatechange = (event) => {
    updateStatus(
      statusElement,
      `ICE connection state changed to: ${peerConnection.iceConnectionState}`,
    );
  };

  // Start session
  await startSession(sessionInfo.session_id, localDescription);


  setTimeout(function() {
    repeatHandler('Ola! My name is Ištvanaa. You can ask me anything about wien museum exhibition, I can describe images or navigate you to pages.');
  }, 1000);

  updateStatus('Session started successfully');

  openAndCloseControl(true);
}

function openAndCloseControl(open = true) {
  if(open) {
  $('.switchRow').show();
  $('#startBtn').hide();
  $('#closeBtn').show();
  $('.buttonControl').show();
  $('.heygenControl').show();
  $('.conversation').show();
  $('.videoSectionWrap').show();
  } else {
  $('#startBtn').hide();
  $('#closeBtn').hide();
  $('.buttonControl').hide();
  $('#newBtn').show();
  $('.heygencontrol').hide();
  $('.conversation').hide();
  $('.videoSectionWrap').hide()
  $('.switchRow').hide();
  }

}


// stop session
async function stopSession(session_id) {
  const response = await fetch(`${SERVER_URL}/v1/streaming.stop`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Api-Key': apiKey,
    },
    body: JSON.stringify({ session_id }),
  });
  if (response.status === 500) {
    console.error('Server error');
    updateStatus('Server Error. Please ask the staff for help');
    throw new Error('Server error');
  } else {
    const data = await response.json();
    return data.data;
  }
}

// remove background
const removeBGCheckbox = document.querySelector('#removeBGCheckbox');
removeBGCheckbox.addEventListener('click', () => {
  const isChecked = removeBGCheckbox.checked; // status after click

  if (isChecked && !sessionInfo) {
    updateStatus('Please create a connection first');
    removeBGCheckbox.checked = false;
    return;
  }

  if (isChecked && !mediaCanPlay) {
    updateStatus('Please wait for the video to load');
    removeBGCheckbox.checked = false;
    return;
  }

  if (isChecked) {
    hideElement(mediaElement);
    showElement(canvasElement);

    renderCanvas();
  } else {
    hideElement(canvasElement);
    showElement(mediaElement);

    renderID++;
  }
});

let renderID = 0;
function renderCanvas() {
  if (!removeBGCheckbox.checked) return;
  hideElement(mediaElement);
  showElement(canvasElement);

  canvasElement.classList.add('show');

  const curRenderID = Math.trunc(Math.random() * 1000000000);
  renderID = curRenderID;

  const ctx = canvasElement.getContext('2d', { willReadFrequently: true });


    var background = 'url("http://localhost/empty_8/items/openai/assets/background2.png") center / contain no-repeat'
    canvasElement.parentElement.style.background = background.trim();


  function processFrame() {
    if (!removeBGCheckbox.checked) return;
    if (curRenderID !== renderID) return;

    canvasElement.width = mediaElement.videoWidth;
    canvasElement.height = mediaElement.videoHeight;

    ctx.drawImage(mediaElement, 0, 0, canvasElement.width, canvasElement.height);
    ctx.getContextAttributes().willReadFrequently = true;
    const imageData = ctx.getImageData(0, 0, canvasElement.width, canvasElement.height);
    const data = imageData.data;

    for (let i = 0; i < data.length; i += 4) {
      const red = data[i];
      const green = data[i + 1];
      const blue = data[i + 2];

      // You can implement your own logic here
      if (isCloseToGreen([red, green, blue])) {
        // if (isCloseToGray([red, green, blue])) {
        data[i + 3] = 0;
      }
    }

    ctx.putImageData(imageData, 0, 0);

    requestAnimationFrame(processFrame);
  }

  processFrame();
}

function isCloseToGreen(color) {
  const [red, green, blue] = color;
  return green > 90 && red < 90 && blue < 90;
}

function hideElement(element) {
  element.classList.add('hide');
  element.classList.remove('show');
}
function showElement(element) {
  element.classList.add('show');
  element.classList.remove('hide');
}

const mediaElement = document.querySelector('#mediaElement');
let mediaCanPlay = false;
mediaElement.onloadedmetadata = () => {
  mediaCanPlay = true;
  mediaElement.play();

  showElement(bgCheckboxWrap);
};
const canvasElement = document.querySelector('#canvasElement');

const bgCheckboxWrap = document.querySelector('#bgCheckboxWrap');


// status updating
function updateStatus(message) {
  $('#status').html('');
  $('#status').html(message );

  $('#status').html(message);
  setTimeout(function() {
  $('#status').html('');
}, 3000);
}

// on message
function onMessage(event) {
  const message = event.data;
  updateStatus('Received message');

}

// loading
function loading(isLoading) {
  if (isLoading) {
      $('.conversation').prepend('<div class="loader"></div>');
    } else {
      $('.loader').hide();
  }
}

// prepend message
function prependMessage(message, isUser = false) {
  var messageElement = $('<div/>', {
    'class': 'message ' + (isUser ? 'user' : 'ai'),
    'text': (isUser ? 'You' : 'AI') + ": " + message
  });

  $('.conversation').prepend(messageElement);
}

function prependElem(elem, isUser = false) {
  var messageElement = $('<div/>', {
    'class': 'message ' + (isUser ? 'user' : 'ai'),
  });

  messageElement.append(elem);

  $('.conversation').prepend(messageElement);
}


// MAIN
//

updateStatus('Please click the new button to create the stream first.');


var taskInput = $('#taskInput');

// repeat
// When clicking the "Send Task" button, get the content from the input field, then send the tas
async function repeatHandler(textParam = '') {
  loading(true);
  updateStatus('Sending task... please wait');


  if (!sessionInfo) {
    updateStatus('Please create a connection first');

    return;
  }

  var text = taskInput.val();


  if (textParam !== '' && !(textParam instanceof PointerEvent)) {
    text = textParam;
  }


    loading(false);

    prependMessage(text, false);


  if (text.trim() === '') {
    alert('Please enter a task');
    return;
  }

  const resp = await repeat(sessionInfo.session_id, text);

  updateStatus('Task sent successfully');
}


async function repeat(session_id, text) {
  const response = await fetch(`${SERVER_URL}/v1/streaming.task`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Api-Key': apiKey,
    },
    body: JSON.stringify({ session_id, text }),
  });
  if (response.status === 500) {
    console.error('Server error');
    updateStatus(
      statusElement,
      'Server Error. Please ask the staff if the service has been turned on',
    );
    throw new Error('Server error');
  } else {
    const data = await response.json();
    return data.data;
  }
}


// talk
async function talkHandler(textParam = '') {

    updateStatus('Sending task... please wait');


  if (!sessionInfo) {
    updateStatus('Please create a connection first');
    return;
  }


  var prompt = taskInput.val(); // Using the same input for simplicity

  if (textParam !== '' && !(textParam instanceof PointerEvent)) {
    prompt = textParam;
  }

  if (prompt.trim() === '') {
    alert('Please enter a prompt for the LLM');
    return;
  }

  loading(false);

  prependMessage(prompt, true);

  loading(true);


  try {
    const text = await talkToOpenAI(prompt);

    if (text) {
      const resp = await repeat(sessionInfo.session_id, text);
      console.log('LLM response sent successfully')
    } else {
      console.log('Failed to get a response from AI');
    }
  } catch (error) {
    console.error('Error talking to AI:', error);
  }
}

async function talkToOpenAI(prompt) {
  try {
    const response = await axios.post(`${HOST}OpenaiController/heygenTalk`, { question: prompt });

    loading(false);

    if (!commandProcessing(response.data)) {
        return;
    }

    let responseString = response.data.response;
    if(responseString === undefined) {
      console.error('Error talking to AI:', response.data);
      return null;
    } else {



      prependMessage(responseString, false);

      return responseString;
    }
  } catch (error) {
    console.error('Server error', error);
    // Handle error
  }
}


// vision

$('#visionBtn').on('click', function() {
    loading(true);

    updateStatus('Sending task... please wait');

    var btn = $(this);
    var image_path = btn.attr('image_path');

    $.ajax({
        url: rootUrl + 'OpenaiController/vision',
        type: 'POST',
        data: {image_path: image_path},
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {

                var inputElem = '<div class="imageWrap" style="width:400px; height:auto;"><img src="' + image_path + '" class="img-fluid" style="width:100%; height:auto;" /></div>';

                prependElem(inputElem, false);

                var response = data.response;

                repeatHandler(response, inputElem);
                loading(false);
            } else {
                alert('Failed to read image');
            }
        }
    });

});


  // speak
var recorder;
var intervalId;

function startCountdown() {
    var counter = 10;
    intervalId = setInterval(function() {
        counter--;
        // Display 'Recording...' for the first second, then start the countdown
        $('#audioCounter').html(counter > 0 ? "recording... " + counter : '');
        if (counter === 0) {
            clearInterval(intervalId);
            if (recorder && recorder.state == 'recording') {
                recorder.stop();
            }
        }
    }, 1000);
}

  var audio = document.querySelector('audio');

  $('#askBtn').on('click', function() {

    updateStatus('Sending task... please wait');

    var btn = $(this);
    var stream; // Declare stream variable outside the if-else block
    if (btn.html() == microphoneIcon) {

        startCountdown();
        // Start recording
        btn.html(recordIcon);
        navigator.mediaDevices.getUserMedia({ audio: true }).then(function(mediaStream) {
            stream = mediaStream; // Assign the MediaStream to the stream variable
            recorder = new MediaRecorder(stream);
            recorder.start();

            var audioChunks = [];
            recorder.addEventListener("dataavailable", function(event) {
                audioChunks.push(event.data);
            });

            recorder.addEventListener("stop", function() {
                loading(true)
                // Stop all tracks of the MediaStream
                stream.getTracks().forEach(function(track) {
                    track.stop();
                });

                var audioData = new Blob(audioChunks);
                var audioUrl = URL.createObjectURL(audioData);
                audio.src = audioUrl;
                var formData = new FormData();
                formData.append('audio', audioData);
                $.ajax({
                    url: rootUrl + 'OpenaiController/speechAskChatGPT',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {

                            loading(false);

                            if (!commandProcessing(data)) {
                                return;
                            }

                            var response = data.response;


                            talkHandler(response);

                            // repeatHandler(aiResponse, false);


                        } else {
                            alert('Failed to send the audio');
                        }
                    }
                });
            });
        });
    } else {
        // Stop recording
        clearInterval(intervalId);
        $('#audioCounter').html('');
        btn.html(microphoneIcon);
        if (recorder && recorder.state == 'recording') {
            recorder.stop();
        }
    }
});

function commandProcessing(data) {

    if (!data.success) {
        console.error('Error talking to AI:', data);
        return false;
    }
    if (data.command !== undefined && data.command !== null) {
        if(data.command === 'redirect') {
            window.location.href = data.value;
            return false;
        }
    }
    return true;
}

});
</script>
