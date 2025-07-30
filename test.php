<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<input type="text" id="text" placeholder="Enter announcement" />
<button onclick="announce()">Announce</button>

<!-- Ting sound (placed in the same folder) -->
<audio id="ting" src="ting.mp3" preload="auto"></audio>


    
</body>
</html>


<script>
  let repeatCount = 0;

  function announce() {
    repeatCount = 0; // Reset counter
    playTingAndSpeak();
  }

  function playTingAndSpeak() {
    const text = document.getElementById("text").value;
    const ting = document.getElementById("ting");

    ting.play();

    ting.onended = () => {
      const speech = new SpeechSynthesisUtterance(text);

      // Voice settings
      speech.lang = "en-US";
      speech.rate = 0.85;
      speech.pitch = 1.1;
      speech.volume = 1;

      const voices = window.speechSynthesis.getVoices();
      speech.voice = voices.find(v => v.name.includes("Google US English"))
                   || voices.find(v => v.lang === "en-US");

      speech.onend = () => {
        repeatCount++;
        if (repeatCount < 2) {
          // ✅ Only do it one more time
          setTimeout(playTingAndSpeak, 500);
        }
        // ❌ No final ting here
      };

      window.speechSynthesis.speak(speech);
    };
  }

  // Ensure voices are loaded
  window.speechSynthesis.onvoiceschanged = () => {
    window.speechSynthesis.getVoices();
  };
</script>
