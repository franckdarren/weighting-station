<!-- Tableau des pesees -->
<x-app-layout>
    <div class="flex flex-col items-center py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <h1 class="text-2xl font-bold">Liste des véhicules pesés</h1>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="mt-6">
                        <div class="mb-10 flex justify-between">
                            <div class="flex items-center border shadow-lg w-[40%] rounded-full px-3 bg-[#e2dfdf] text-[#7a7a7a]">
                                <input type="text" id="search" placeholder="Rechercher par Matricule" class="w-full px-3 py-2 border-none focus:ring-transparent bg-[#e2dfdf]">
                                <i class="fa-solid fa-magnifying-glass fa-rotate-90 me-2"></i>
                            </div>
                            <div>
                                <button class="border border-[#19a91e] text-[#19a91e] py-1 px-8 hover:animate-bounce">
                                    <i class="fa-solid fa-download fa-bounce me-1"></i>
                                    Export
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">ID</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Name</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Email</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Address</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">City</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Country</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Zip</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Website</th>
                                        <th class="px-6 py-3 text-left text-xs text-[#d92550] uppercase tracking-wider font-semibold">Company</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($users as $index => $user)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-[#e6eef6]' }}">
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['id'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['name'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['email'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['phone'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['address'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['city'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['country'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['zip'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['website'] }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="border px-3 border-gray-300 bg-white">{{ $user['company'] }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Filtre sur le tableau pour la barre de recherche -->
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.querySelector("table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
</script>