<div class="overflow-x-auto -mx-2 sm:mx-0 mt-2">
    <div class="inline-block min-w-full sm:px-0 px-2">
        <table class="w-full text-sm border border-black" style="border-collapse: collapse;">
            <thead>
                <tr class="text-center">
                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">SUBJECT</th>
                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANDARD SCORE</th>
                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANINE</th>
                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">QUALITATIVE INTERPRETATION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">ENGLISH</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->english_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->english_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->english_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->science_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->science_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->science_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->math_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->math_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->math_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->filipino_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->filipino_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->filipino_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->social_studies_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->social_studies_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->social_studies_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">ESM COMPETENCY SCORE</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->esm_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->esm_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->esm_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">OVERALL SCORE</td>
                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->total_standard_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->total_raw_score ?? '' }}</td>
                    <td class="border border-black px-2 py-1 text-xs sm:text-sm font-bold">{{ $this->stanineInterpretation($result->total_raw_score) }}</td>
                </tr>
                <!-- Score Definitions inside table -->
                <tr>
                    <td colspan="4" class="border border-black px-2 py-2 text-xs text-justify print-score-definitions" style="line-height: 1.4; background-color: transparent;">
                        <p class="mb-2">
                            <span class="font-bold italic">OVERALL SCORE</span> – The composite score based on all subjects taken in the SKSU TPT. This score is used for admission to all other college programs not included under the EMS Score.
                        </p>
                        <p>
                            <span class="font-bold italic">ESM COMPETENCY SCORE</span> - The composite score based only on English, Mathematics, and Science. This score is used for admission to the following college programs: Nursing, Midwifery, Medical Technology, Electronics Engineering, Civil Engineering, Computer Engineering, Computer Science, Fisheries, Biology, Accountancy, Management Accounting, Accounting Information Systems, Mathematics Education, and Science Education.
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
