
</body>
</html>  
  
<script>
    function showForm(department) {
      document.getElementById('department-form').classList.remove('hidden');
      document.getElementById('dashboard-title').classList.add('hidden');
      document.getElementById('department-buttons').classList.add('hidden');
      document.getElementById('selected-department').textContent = department; 
    }

    function submitForm() {
      const department = document.getElementById('selected-department').textContent;
      const transaction = document.getElementById('transaction-type').value;
      const now = new Date();
      const formattedDateTime = now.toLocaleString('en-US', {
        dateStyle: 'full',
        timeStyle: 'short',
      });

      const ticketNumber = 'A' + Math.floor(100 + Math.random() * 900);
      const queueBefore = 2;

      const ticketHTML = `
        <header class="w-full bg-[#07214A] px-6 py-4 shadow-md border-b-4 border-[#F0BB3F]">
          <div class="flex items-center space-x-4">
            <img src="images/Logo.svg" alt="Logo" class="w-12 h-12 object-contain" />
            <h1 class="text-white text-xl sm:text-2xl font-bold">Immaculada Conception College</h1>
          </div>
        </header>
        <div class="flex justify-center items-center min-h-[calc(100vh-100px)] px-4 py-10">
          <div class="bg-white rounded-lg shadow-xl p-8 max-w-xl w-full text-center space-y-6 border border-gray-300">
            <img src="images/Logo.svg" alt="Logo" class="w-20 h-20 mx-auto">
            <h2 class="text-xl font-bold text-[#07214A]">Immaculada Conception College of Soldier Hills Inc.</h2>
            <p class="text-lg text-gray-700">Your ticket number is</p>
            <div class="text-5xl font-extrabold text-[#F0BB3F]">${ticketNumber}</div>
            <div class="text-md font-semibold text-gray-800">Department: <span class="text-[#07214A]">${department}</span></div>
            <div class="text-md font-semibold text-gray-800">Transaction Type: <span class="text-[#07214A]">${transaction}</span></div>
            <p class="text-gray-600">There are <strong>${queueBefore}</strong> queuing before you</p>
            <div class="pt-4 border-t border-gray-300">
              <div class="font-bold text-[#07214A]">QUEUE# GENERATED</div>
              <div class="text-sm text-gray-500">${formattedDateTime}</div>
            </div>
          </div>
        </div>
      `;
      document.querySelector('main').innerHTML = ticketHTML;
      document.getElementById('ticket-feedback').classList.remove('hidden');
    }

    // Feedback Modal Logic
    const feedbackBtn = document.getElementById('feedbackBtn');
    const feedbackModal = document.getElementById('feedbackModal');
    const submitFeedbackBtn = document.getElementById('submitFeedbackBtn');

    if (feedbackBtn) {
      feedbackBtn.addEventListener('click', () => {
        feedbackModal.classList.remove('hidden');
      });
    }

    if (feedbackModal) {
      feedbackModal.addEventListener('click', (e) => {
        if (e.target === feedbackModal) {
          feedbackModal.classList.add('hidden');
        }
      });
    }

    const stars = document.querySelectorAll('#starRating .star');
    let currentRating = 0;
    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        currentRating = index + 1;
        stars.forEach((s, i) => {
          s.classList.toggle('text-yellow-400', i < currentRating);
          s.classList.toggle('text-gray-300', i >= currentRating);
        });
      });
    });

    if (submitFeedbackBtn) {
      submitFeedbackBtn.addEventListener('click', () => {
        alert('Thanks for your feedback!');
        feedbackModal.classList.add('hidden');
      });
    }
</script>

<script>
function shouldShowModal() {
  const now = new Date();
  const manilaTime = new Date(
    now.toLocaleString("en-US", { timeZone: "Asia/Manila" })
  );

  const hours = manilaTime.getHours();
  const minutes = manilaTime.getMinutes();

const totalMinutes = hours * 60 + minutes;

// if (totalMinutes >= 451 && totalMinutes >= 1050) {
//   // 451 = 7 * 60 + 31 (7:31 AM)
//   // 1050 = 17 * 60 + 30 (5:30 PM)
//   return true;
// }
  // // Show modal outside blocked time
  return false;
}

function checkModalDisplay() {
  if (shouldShowModal()) {
    document.getElementById("myModal").style.display = "flex";
  } else {
    document.getElementById("myModal").style.display = "none";
  }
}

// Run on load
checkModalDisplay();

// Then check every minute
setInterval(checkModalDisplay, 1000);


</script>

<script>
  document.getElementById("showModalBtn").addEventListener("click", function () {
  document.getElementById("receipt_modal").style.display = "flex";
});

  document.getElementById("returnBtn").addEventListener("click", function () {
  document.getElementById("receipt_modal").style.display = "none";
});

document.getElementById("printBtn").addEventListener("click", function () {
  window.print();
});
</script>