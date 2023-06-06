<div>
    <div>
        <div class="flex flex-col mt-1">
            <p class="px-3 py-2 border-t text-lg text-gray-500 whitespace-wrap">
                <div class="h-1 "></div>
                @if ($result != null)
                @if ($result->total_standard_score >= 525 && $result->total_standard_score <= 800)
                <p> Congratulations! You have passed the admission test (SKSU-TPT).
                You are qualified to take both board and non-board degree programs.
                The next step is the interview scheduled on <span class="font-bold">June 26-30, 2023.</span>
                Please bring the printed copy of the SKSU-TPT result, first semester grades and School ID or any valid ID.
                The completion of this process will be the basis for ranking to qualify for enrollment.
                God bless.</p>
                @elseif($result->total_standard_score >= 375 && $result->total_standard_score <= 524)
                <p>Congratulations! You have passed the admission test (SKSU TPT).
                You are qualified to take non-board degree programs.
                The next step is the interview schedule on <span class="font-bold">June 26-30, 2023</span>.
                Please bring the printed copy of the SKSU-TPT result,
                first semester grades and School ID or any valid ID. The completion of this process will be the basis for ranking to qualify for enrollment.
                God bless.</p>
                @elseif($result->total_standard_score >= 200 && $result->total_standard_score <= 374)
                <p>Thank you for considering SKSU as your preferred institution
                but you are recommended to enroll in other institution of your choice.</p>
                @endif
                @endif

            </p>
            {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>

                                        <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                       </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($result->total_standard_score >= 525 && $result->total_standard_score <= 800)
                                <tr>
                                    <td rowspan="3" class="px-3 py-4 border border-l text-md text-gray-500 whitespace-wrap">
                                        Congratulations! You have passed the admission test (SKSU-TPT).
                                        You are qualified to take both board and non-board degree programs.
                                        The next step is the interview scheduled on <span class="font-bold">June 26-30, 2023</span>.
                                        Please bring the printed copy of the SKSU-TPT result, first semester grades and School ID or any valid ID.
                                        God bless.
                                    </td>
                                </tr>
                                @elseif($result->total_standard_score >= 375 && $result->total_standard_score <= 524)
                                <tr>
                                    <td rowspan="2" class="px-3 py-4 border border-l text-sm text-gray-500 whitespace-wrap">
                                        Congratulations! You have passed the admission test (SKSU TPT).
                                        You are qualified to take non-board degree programs.
                                        The next step is the interview schedule on <span class="font-bold">June 26-30, 2023</span>.
                                        Please bring the printed copy of the SKSU-TPT result,
                                        first semester grades and School ID or any valid ID.
                                        God bless.
                                    </td>
                                </tr>
                                @elseif($result->total_standard_score >= 200 && $result->total_standard_score <= 374)
                                <tr>
                                    <td rowspan="2" class="px-3 py-4 border border-l text-sm text-gray-500 whitespace-wrap">
                                        Thank you for considering SKSU as your preferred institution
                                        but you are recommended to enroll in other institution of your choice.
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

</div>
