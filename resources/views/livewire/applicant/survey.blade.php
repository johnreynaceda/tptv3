<div>
    <div class="p-4">
        <h2 class="text-md font-semibold mb-3">1. The pre-registration process is easy and convenient.</h2>
        @error('question_1') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_1" type="radio" value="1" name="question1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_1" type="radio" value="2" name="question1" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_1" type="radio" value="3" name="question1" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_1" type="radio" value="4" name="question1" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_1" type="radio" value="5" name="question1" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">2. The testing personnel (ex. examiners, proctors, peer helpers, security guards and staff) responds efficiently to the needs and concerns of the examinees.</h2>
        @error('question_2') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_2" type="radio" name="question2" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_2" type="radio" name="question2" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_2" type="radio" name="question2" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_2" type="radio" name="question2" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_2" type="radio" name="question2" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">3. The signages in the testing site are visible and easy to follow.</h2>
        @error('question_3') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_3" type="radio" name="question3" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_3" type="radio" name="question3" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_3" type="radio" name="question3" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_3" type="radio" name="question3" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_3" type="radio" name="question3" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">4. There are enough rooms and facilities to cater the examinees.</h2>
        @error('question_4') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_4" type="radio" name="question4" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_4" type="radio" name="question4" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_4" type="radio" name="question4" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_4" type="radio" name="question4" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_4" type="radio" name="question4" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">5. The testing room is conducive and well-ventilated.</h2>
        @error('question_5') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_5" type="radio" name="question5" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_5" type="radio" name="question5" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_5" type="radio" name="question5" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_5" type="radio" name="question5" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_5" type="radio" name="question5" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">6. The examinees are well-guided of the instructions and procedures before, during and after the
            examination.
            </h2>
            @error('question_6') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_6" type="radio" name="question6" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_6" type="radio" name="question6" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_6" type="radio" name="question6" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_6" type="radio" name="question6" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_6" type="radio" name="question6" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">7. The test materials are readable, sufficient and in good condition.</h2>
        @error('question_7') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_7" type="radio" name="question7" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_7" type="radio" name="question7" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_7" type="radio" name="question7" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_7" type="radio" name="question7" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_7" type="radio" name="question7" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">8. The duration of the test is adequate.</h2>
        @error('question_8') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_8" type="radio" name="question8" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_8" type="radio" name="question8" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_8" type="radio" name="question8" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_8" type="radio" name="question8" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_8" type="radio" name="question8" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">9. The test items per subject are adequate and appropriate.</h2>
        @error('question_9') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_9" type="radio" name="question9" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_9" type="radio" name="question9" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_9" type="radio" name="question9" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_9" type="radio" name="question9" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_9" type="radio" name="question9" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-md font-semibold mb-4">10. The test questions are comprehensible.</h2>
        @error('question_10') <span class="error text-red-500">{{ $message }}</span> @enderror
        <div class="space-y-2 mt-2">
          <label class="flex items-center">
            <input wire:model="question_10" type="radio" name="question10" value="1" class="form-radio">
            <span class="ml-2">Strongly Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_10" type="radio" name="question10" value="2" class="form-radio">
            <span class="ml-2">Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_10" type="radio" name="question10" value="3" class="form-radio">
            <span class="ml-2">Neither Disagree nor Agree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_10" type="radio" name="question10" value="4" class="form-radio">
            <span class="ml-2">Disagree</span>
          </label>
          <label class="flex items-center">
            <input wire:model="question_10" type="radio" name="question10" value="5" class="form-radio">
            <span class="ml-2">Strongly Disagree</span>
          </label>
        </div>
      </div>
      <div class="h-1 bg-gray-700"></div>
      <div class="p-4">
        <h2 class="text-md font-semibold mb-2">Comments and Suggestions...</h2>
        <div class="space-y-2">
            <textarea wire:model="comment" class="w-full rounded-sm p-3 h-24"></textarea>
        </div>
      </div>
      <div class="flex justify-end mr-4">
        <x-button emerald label="Submit"
        x-on:confirm="{
            title: 'Are you Sure?',
            description: 'Save the information?',
            acceptlabel: 'Yes, save it',
            icon: 'info',
            method: 'save',
            params: 1
        }"
        />
      </div>
</div>
