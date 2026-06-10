@extends('layout.app')

@section('title', 'Contact - DigitalSpace')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="grid lg:grid-cols-5 gap-16 items-start">
        
        <!-- Info Side -->
        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-6xl font-bold text-slate-900 leading-tight">Parlons de votre <span class="text-primary italic font-display">Projet</span></h1>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Vous avez une idée, un besoin technique ou simplement une question ? Notre équipe d'experts est à votre écoute.
                </p>
            </div>

            <div class="space-y-8">
                <div class="flex items-start gap-6 group">
                    <div class="w-14 h-14 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-xl group-hover:bg-primary group-hover:text-white transition-all duration-500">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Email Expert</h4>
                        <p class="text-slate-500">contact@digitalspace.com</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 group">
                    <div class="w-14 h-14 bg-secondary/5 text-secondary rounded-2xl flex items-center justify-center text-xl group-hover:bg-secondary group-hover:text-white transition-all duration-500">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Assistance Directe</h4>
                        <p class="text-slate-500">+226 00 00 00 00</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 group">
                    <div class="w-14 h-14 bg-accent/5 text-accent rounded-2xl flex items-center justify-center text-xl group-hover:bg-accent group-hover:text-white transition-all duration-500">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Siège Social</h4>
                        <p class="text-slate-500">Ouagadougou, Zone 1, BF</p>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="pt-8 border-t border-slate-100 flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white transition-all"><i class="fab fa-facebook-f text-xs"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all"><i class="fab fa-whatsapp text-xs"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><i class="fab fa-youtube text-xs"></i></a>
            </div>
        </div>

        <!-- Form Side -->
        <div class="lg:col-span-3">
            <div class="bg-white p-10 md:p-14 rounded-[3.5rem] border border-slate-100 shadow-glow relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 blur-3xl rounded-full"></div>
                
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Honeypot (Anti-spam) -->
                    <div class="hidden">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Votre Nom</label>
                            <div class="relative group">
                                <i class="fas fa-user absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="name" required placeholder="Jean Dupont" value="{{ old('name') }}"
                                       class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-14 pr-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700">
                            </div>
                            @error('name') <p class="text-danger text-[10px] font-bold mt-1 ml-4 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Votre Email</label>
                            <div class="relative group">
                                <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="email" name="email" required placeholder="jean@exemple.com" value="{{ old('email') }}"
                                       class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-14 pr-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700">
                            </div>
                            @error('email') <p class="text-danger text-[10px] font-bold mt-1 ml-4 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Sujet de la demande</label>
                        <div class="relative group">
                            <i class="fas fa-tag absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                            <input type="text" name="subject" required placeholder="Ex: Collaboration sur un projet Web" value="{{ old('subject') }}"
                                   class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-14 pr-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700">
                        </div>
                        @error('subject') <p class="text-danger text-[10px] font-bold mt-1 ml-4 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Votre Message</label>
                        <div class="relative group">
                            <i class="fas fa-comment-dots absolute left-6 top-6 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                            <textarea name="message" required rows="6" placeholder="Décrivez votre besoin en quelques lignes..."
                                      class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-14 pr-6 py-5 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700">{{ old('message') }}</textarea>
                        </div>
                        @error('message') <p class="text-danger text-[10px] font-bold mt-1 ml-4 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-slate-900 text-white rounded-2xl py-5 font-black uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/20 hover:bg-primary hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-4 group">
                            <span>Envoyer le Message</span>
                            <i class="fas fa-paper-plane text-xs group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
