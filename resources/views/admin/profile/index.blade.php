@extends('layout.app')

@section('title', 'Mon Profil - DigitalSpace')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-16">
    <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <!-- Header Image/Pattern -->
        <div class="h-48 bg-gradient-to-r from-primary to-primary-dark relative">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
        </div>

        <div class="px-10 pb-16 relative">
            <!-- Profile Picture -->
            <div class="absolute -top-24 left-10">
                <div class="w-48 h-48 rounded-[3.5rem] bg-white p-3 shadow-2xl">
                    <div class="w-full h-full rounded-[2.8rem] overflow-hidden bg-slate-100">
                        @if($admin->profile_picture)
                            <img src="{{ asset('storage/' . $admin->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-primary flex items-center justify-center text-white text-7xl font-black">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pt-28 flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tight">{{ $admin->name }}</h1>
                    <div class="flex items-center gap-3 mt-4">
                        <span class="px-5 py-2 bg-primary/10 text-primary rounded-full text-xs font-black uppercase tracking-widest border border-primary/10">
                            {{ $admin->role }}
                        </span>
                        <span class="text-slate-400 font-bold">•</span>
                        <span class="text-slate-500 font-medium">{{ $admin->email }}</span>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('admin.profile.edit') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-900/10 hover:bg-primary transition-all flex items-center gap-3">
                        <i class="fas fa-edit"></i>
                        <span>Modifier le profil</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 border-t border-slate-50 pt-16">
                <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Inscrit depuis</p>
                    <p class="text-xl font-bold text-slate-900">{{ $admin->created_at->format('M Y') }}</p>
                </div>
                <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Articles rédigés</p>
                    <p class="text-xl font-bold text-slate-900">{{ $admin->posts_count ?? $admin->posts()->count() }}</p>
                </div>
                <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Status Compte</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 shadow-lg shadow-green-500/50"></div>
                        <p class="text-xl font-bold text-slate-900">Actif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
