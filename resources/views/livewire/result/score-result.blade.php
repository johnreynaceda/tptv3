<div>
    {{ $examinee_number }}
    @if ($result == null)
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">
                Please be informed that the scoring machine of SKSU TPT cannot recognize your answer sheet
                due
                to either of the following reasons:
            </h3>
            <div class="mt-2 text-sm text-red-700">
                <ul role="list"
                    class="pl-5 space-y-1 list-disc">
                    <li>
                        Duplication of examinee ID number
                    </li>
                    <li>
                        Incorrect marking
                    </li>
                    <li>
                        Light shaded marking
                    </li>
                    <li>
                        Two or more answers shaded answers in one item
                    </li>
                    <li>
                        Spoiled answer sheet
                    </li>
                    <li>
                        Crumpled answer sheet
                    </li>
                </ul>
            </div>
            <h3 class="mt-2 text-sm font-medium text-red-800">
                Therefore, your examination is considered invalid.
            </h3>
        </div>
    @else
        <div class="flex flex-col mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Course</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Standar Score</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Qualitative Interpretation</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        Mathematics
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->math_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->math_standard_score) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        English
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->english_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->english_standard_score) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        Filipino
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->filipino_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->filipino_standard_score) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        Science
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->science_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->science_standard_score) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        Social Studies
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->social_studies_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->social_studies_standard_score) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-6">
                                        Overall
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $result->total_standard_score }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $this->scoreInterpretation($result->total_standard_score) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div class="mb-2">
                Remarks :
            </div>
            <div class="flex space-x-2">
                @if ($result->total_standard_score < 527)
                    <span
                        class="inline-flex border items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Qualified for Non-Board Courses
                    </span>
                @endif
                @if ($result->total_standard_score >= 527)
                    <span
                        class="inline-flex border items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Qualified for Non-Board Courses
                    </span>
                    <span
                        class="inline-flex border items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Qualified for Board Courses
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
