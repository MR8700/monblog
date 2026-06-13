@extends('layout.app')

@section('title', 'Gestion des Administrateurs - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">Administrateurs</h1>
                <p class="text-slate-600">Gérez les accès et les rôles de votre équipe.</p>
            </div>
            <a href="{{ route('admin.admins.create') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-105 transition flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Nouvel Admin
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-soft">
            <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3 relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou Email..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                </div>
                <div class="flex gap-2">
                    <select name="role" class="flex-1 px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    <button type="submit" class="px-6 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl relative">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Nom & Email</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Rôle</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($admins as $admin)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden border-2 border-slate-100 shadow-sm flex-none">
                                        @if($admin->profile_picture)
                                            <img src="{{ asset('storage/' . $admin->profile_picture) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-black">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900">{{ $admin->name }}</span>
                                        <span class="text-sm text-slate-400">{{ $admin->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $admin->isSuperAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $admin->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($admin->is_suspended)
                                    <span class="inline-flex items-center gap-2 text-red-600 font-bold text-sm">
                                        <i class="fas fa-ban"></i> Suspendu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 text-green-600 font-bold text-sm">
                                        <i class="fas fa-check-circle"></i> Actif
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="p-2 text-slate-400 hover:text-primary transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($admin->id !== auth()->id())
                                        <form action="{{ route('admin.admins.toggle-suspension', $admin) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 {{ $admin->is_suspended ? 'text-green-500 hover:text-green-600' : 'text-amber-500 hover:text-amber-600' }} transition" title="{{ $admin->is_suspended ? 'Activer' : 'Suspendre' }}">
                                                <i class="fas {{ $admin->is_suspended ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet administrateur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:text-red-500 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>
</section>
@endsection
