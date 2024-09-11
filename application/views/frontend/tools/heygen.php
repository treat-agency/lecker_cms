<style>
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  padding: 24px;
}



.main {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.actionRowsWrap {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.actionRow {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}

.actionRow label {
  display: flex;
  align-items: center;
  gap: 8px;
}

button {
  display: inline-block;
  padding: 0 16px;
  border-radius: 8px;
  height: 40px;

  background-color: #4caf50; /* Green */
  border: none;

  color: #fff;
  text-align: center;
  font-size: 16px;

  cursor: pointer;
  transition-duration: 0.4s;
}

button:hover {
  background-color: #45a049;
}

input {
  height: 40px;
  padding: 0 12px;

  font-size: 16px;
}

/* #status {
  overflow: auto;

  background-color: #fff;
  height: 120px;
  padding: 10px 12px;

  border: 1px solid #ccc;
  border-radius: 8px;

  font-size: 14px;
  line-height: 1.6;
} */

.videoSectionWrap {
  position: relative;

  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.actionRow.switchRow {
  width: 100%;

  justify-content: center;
}
.switchRow {
  flex-direction: column;
}
.switchRow > label {
  width: 100%;

  display: flex;
  justify-content: center;
}

.switchRow > label input {
  flex: 1;
  max-width: 500px;
}

.videoSectionWrap .videoWrap {
  display: flex;
  justify-content: center;
  align-items: center;

  /*background: linear-gradient(0deg, rgba(0, 0, 0, 0.02) 0%, rgba(0, 0, 0, 0.02) 100%),*/
  /*  radial-gradient(*/
  /*    108.09% 141.42% at 0% 100%,*/
  /*    rgba(219, 255, 213, 0.3) 0%,*/
  /*    rgba(255, 255, 255, 0) 100%*/
  /*  ),*/
  /*  linear-gradient(135deg, #ffeede 5.71%, #ffd9d9 47%, #a3dce7 93.47%);*/
}

.videoWrap .videoEle {
  width: 100%;
  max-height: 400px;
}

/*---------- Switch START ----------*/
.switchWrap {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
}

.conversation {
  display: flex;
  flex-direction: column;
  gap: 12px;
  height: 400px;
  overflow: scroll;
}

.user {
  background-color: beige;
  padding: 12px;
  border-radius: 8px;
  max-width: 80%;
  color: black
}

.ai {
  background-color: lightblue;
  padding: 12px;
  border-radius: 8px;
  max-width: 80%;
  color: black
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: '';
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2196f3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
/*---------- Switch END ----------*/

.videoSectionWrap .hide {
  display: none;
}

.videoSectionWrap .show {
  display: flex;
}

.hide {
  display: none;
}
.show {
  display: flex;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 15px;
    height: 15px;
    animation: spin 2s linear infinite;
}

</style>

<!doctype html>
<html>
  <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" href="./favicon.ico" />
  </head>

  <body>
    <div class="main">
      <div class="actionRowsWrap">
        <div class="actionRow heygenControl">


          <button id="newBtn">New Chat</button>
          <button id="startBtn" style="display:none">Start</button>
          <button id="closeBtn" style="display:none">Close</button>
          <p id="status"></p>
        </div>

        <div class="actionRow buttonControl heygenControl" style="display:none">
          <label>
            Message
            <input id="taskInput" type="text" />
          </label>
          <br>
          <button id="repeatBtn"><i class="fas fa-comment"></i></button>
          <button id="talkBtn"><i class="fas fa-paper-plane"></i></button>
          <button id="visionBtn" image_path="https://www.wienmuseum.at/items/uploads/images/1704727162_ZmLHngILPeYm.jpg"><i class="fas fa-eye"></i></button>
          <button id="askBtn"><i class="fas fa-microphone"></i></button>
          <div id="audioCounter"></div>
          <audio id="audio" src=""></audio>

        </div>
      </div>

      <!-- <p id="status"></p> -->



      <div class="videoSectionWrap">
        <div class="videoWrap">
          <video id="mediaElement" class="videoEle show" autoplay></video>
          <canvas id="canvasElement" class="videoEle hide"></canvas>
        </div>

        <div class="actionRow switchRow hide" id="bgCheckboxWrap" style="display:none">
          <div class="switchWrap">
            <span>Remove background</span>
            <label class="switch">
              <input type="checkbox" id="removeBGCheckbox" />
              <span class="slider round"></span>
            </label>
          </div>

        </div>
      </div>
    </div>
      <br>
      <div class="conversation">
      </div>

<? include (getcwd() . '/items/openai/heygen_script.php'); ?>



  </body>
</html>
