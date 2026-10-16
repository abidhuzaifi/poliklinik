<x-layouts.app title="Jadwal Periksa">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Jadwal Periksa
        </h2>

        <a href="{{ route('jadwal-periksa.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 
                  rounded-xl bg-primary hover:bg-primary/90 text-white 
                  font-semibold text-sm transition shadow-sm">
            <i class="fas fa-plus"></i>
            Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 px-5 py-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">No</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">Hari</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">Jam Mulai</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap">Jam Selesai</th>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jadwals as $index => $item)
                    <tr class="hover:bg-slate-50/50 transition duration-200">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $item->hari }}</td>
                        <td class="px-6 py-4">{{ substr($item->jam_mulai, 0, 5) }}</td>
                        <td class="px-6 py-4">{{ substr($item->jam_selesai, 0, 5) }}</td>
                        <td class="px-6 py-4 flex justify-center gap-2">
                            
                            <a href="{{ route('jadwal-periksa.edit', $item->id) }}" 
                               class="flex items-center justify-center w-8 h-8 rounded-lg 
                                      bg-amber-100 text-amber-600 hover:bg-amber-200 transition"
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>

                            <form action="{{ route('jadwal-periksa.destroy', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="flex items-center justify-center w-8 h-8 rounded-lg 
                                               bg-red-100 text-red-600 hover:bg-red-200 transition"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                            
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                                <p>Belum ada jadwal periksa yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>