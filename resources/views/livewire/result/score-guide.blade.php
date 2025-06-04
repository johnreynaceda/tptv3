<div>
    <div>
        <div class="flex flex-col mt-1">
            <p class="px-3 py-2 border-t text-lg text-gray-500 whitespace-wrap">
                <div class="h-1 "></div>
                @if ($result != null)
                @if ($result->total_standard_score >=400)
                <p>Congratulations! You have passed the SKSU Tertiary Placement Test. Please refer to the table below and choose a degree program where you may qualify based on your score and submit yourself for an interview on a set schedule. Please bring the printed copy of the SKSU-TPT result, Grade 12 report card or transcript of record and any valid ID. </p>

              
                @else 
                  <p>Thank you for considering SKSU as your preferred institution
                but you are recommended to enroll in other institution of your choice.</p>
                @endif

                @endif

            </p>
          
        </div>
    </div>

</div>
