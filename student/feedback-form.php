
  <!-- Feedback Button + Modal (only shown on ticket) -->
  <div id="ticket-feedback" class="hidden">
    <!-- Feedback Floating Button -->
    <button id="feedbackBtn" class="fixed bottom-6 left-6 z-50">
      <img src="images/Feedback.png" alt="Feedback" class="w-14 h-14 hover:scale-105 transition-transform" />
    </button>
    
        <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
      <div class="bg-white w-full max-w-2xl rounded-lg overflow-hidden shadow-lg">
        <div class="bg-[#07214A] text-white px-6 py-4 text-xl font-bold">Feedback</div>
        <div class="p-6 space-y-4">
          <input type="text" placeholder="Full Name" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          <input type="email" placeholder="Email Address" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          <input type="text" placeholder="Department Visited" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          <div class="flex gap-4">
            <input type="date" class="flex-1 px-4 py-3 border border-gray-300 rounded-md" />
            <div class="flex items-center gap-1">
              <span class="font-semibold mr-2">Rating:</span>
              <div id="starRating" class="flex space-x-1 cursor-pointer">
                ${[...Array(5)].map(() => `<svg class="w-6 h-6 text-gray-300 hover:text-yellow-400 fill-current star" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.954L10 0l2.951 5.956 6.561.954-4.756 4.635 1.122 6.545z"/></svg>`).join('')}
              </div>
            </div>
          </div>
          <textarea rows="4" placeholder="Comments" class="w-full px-4 py-3 border border-gray-300 rounded-md resize-none"></textarea>
        </div>
        <div class="flex justify-end px-6 py-4">
          <button id="submitFeedbackBtn" class="bg-[#07214A] text-white px-6 py-2 rounded-md hover:bg-[#061835] transition">Submit Feedback</button>
        </div>
      </div>
    </div>
  </div>