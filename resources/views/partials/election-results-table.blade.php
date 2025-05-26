<div class="overflow-x-auto rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Candidate</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Votes</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Percentage</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($election->candidates as $candidate)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($candidate->photo)
                                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}">
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $candidate->name }}</div>
                                <div class="text-sm text-gray-500">{{ $candidate->position }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $candidate->votes_count }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            @if($election->votes->count() > 0)
                                {{ round(($candidate->votes_count / $election->votes->count()) * 100, 2) }}%
                            @else
                                0%
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>