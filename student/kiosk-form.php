    <!-- Department Form -->
    <div id="department-form" class="hidden flex justify-center items-center mt-16">
      <div class="bg-[#ebf0f2] rounded-lg w-[1000px] p-8 space-y-6 shadow-lg">
        <p class="text-base text-[#071c42] text-center">
          <strong>Disclaimer:</strong> By using the ICC Online Queue Registration, you agree to provide accurate information...
        </p>
        <div class="grid grid-cols-2 gap-6">
          <div class="space-y-4">
            <div id="selected-department" readonly class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-700 bg-gray-100 cursor-not-allowed"></div>
            <input type="text" placeholder="Full Name" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          </div>
          <div class="space-y-4">
            <select id="transaction-type" class="w-full px py-[15px] border border-gray-300 rounded-md">
              <option value="">Select Transaction Type</option>
              <option value="Enrollment">Enrollment</option>
              <option value="Grades">Grades</option>
              <option value="Billing">Billing</option>
            </select>
            <input type="text" placeholder="Student ID / LRN" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          </div>
        </div>
        <div class="flex justify-center items-center pt-4">
          <button onclick="submitForm()" class="bg-[#071c42] text-white px-[120px] py-3 rounded-lg text-sm font-semibold hover:bg-[#00284a] transition duration-300">
            Submit
          </button>
        </div>
      </div>
    </div>