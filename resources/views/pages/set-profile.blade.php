<x-app-layout title="User Profile" is-header-blur="true" is-sidebar-open="false" sidebarToggle="false">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex flex-wrap items-center justify-between space-y-3 py-5 lg:py-6">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-navy-300">Account</p>
                <h2 class="text-xl font-semibold text-slate-800 dark:text-navy-50 lg:text-2xl">Profile &amp; Security</h2>
            </div>
            <div class="flex items-center space-x-3">
                <button class="btn h-10 rounded-full border border-slate-200/70 px-4 text-xs+ font-medium text-slate-700 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-50">
                    Preview
                </button>
                <button class="btn h-10 rounded-full bg-primary px-4 text-xs+ font-medium text-white hover:bg-primary-focus dark:bg-accent">
                    Save Changes
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 xl:col-span-4 space-y-4">
                <div class="card p-5">
                    <div class="flex flex-col items-center space-y-4 text-center">
                        <div class="relative">
                            <div class="avatar h-28 w-28">
                                <img class="rounded-full object-cover" src="{{ asset('images/200x200.png') }}" alt="avatar" />
                            </div>
                            <button class="btn absolute -bottom-2 left-1/2 h-8 w-28 -translate-x-1/2 rounded-full border border-white/70 bg-white text-xs font-medium text-slate-700 shadow hover:border-primary dark:border-navy-500 dark:bg-navy-600 dark:text-navy-50">
                                Change
                            </button>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-navy-50">{{ $user->name }}</h3>
                            <p class="text-sm text-slate-400 dark:text-navy-200">{{ $user->email }}</p>
                        </div>
                        <div class="flex w-full flex-col gap-3 rounded-2xl bg-slate-100/60 p-4 text-left dark:bg-navy-700/70">
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Role</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">{{ optional($user->roles->first())->name ?? 'Member' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Projects</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">12 active</span>
                            </div>
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Last Login</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">2 hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                        <button class="btn h-11 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-50">
                            Upload Avatar
                        </button>
                        <button class="btn h-11 rounded-2xl border border-slate-200 text-slate-600 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-100">
                            Remove
                        </button>
                    </div>
                </div>

                <div class="card p-5">
                    <h3 class="text-base font-semibold text-slate-700 dark:text-navy-50">Security Snapshot</h3>
                    <p class="text-xs+ text-slate-400 dark:text-navy-200">Keep your account protected and up to date.</p>
                    <div class="mt-5 space-y-4">
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-50">Password updated</p>
                                <p class="text-xs text-slate-400 dark:text-navy-200">Last changed 45 days ago</p>
                            </div>
                            <button class="btn h-8 rounded-full border border-primary/30 px-3 text-xs text-primary hover:border-primary dark:border-accent/40 dark:text-accent-light">Update</button>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-50">Devices trusted</p>
                                <p class="text-xs text-slate-400 dark:text-navy-200">3 browsers currently verified</p>
                            </div>
                            <button class="btn h-8 rounded-full border border-slate-200 px-3 text-xs text-slate-600 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-100">Review</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-8 space-y-4">
                <div class="card p-5">
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Display name</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter name" type="text" value="{{ $user->name }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-user text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Full name</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter full name" type="text" value="{{ $user->name }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-user text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Email Address</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter email address" type="email" value="{{ $user->email }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-envelope text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Phone Number</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="+1 555 0123 456" type="text" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="card p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-primary">Two Factor Authentication</p>
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-navy-50">Add a second layer of security</h3>
                        </div>
                        <label class="inline-flex items-center space-x-2 text-sm font-medium text-slate-600 dark:text-navy-100">
                            <span>Status</span>
                            <input type="checkbox" class="form-switch h-6 w-11 rounded-full border border-slate-300 bg-slate-200 checked:bg-primary focus:border-primary focus:ring-primary dark:border-navy-500 dark:bg-navy-600" checked />
                        </label>
                    </div>
                    <p class="mt-2 text-sm text-slate-500 dark:text-navy-200">Use an authenticator app or SMS to confirm it is you when you sign in from a new device.</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-primary/30 p-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 dark:text-navy-50">Authenticator App</p>
                                    <p class="text-xs text-slate-400 dark:text-navy-200">Best balance between security and convenience.</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-3 text-sm">
                                <p>1. Install Google Authenticator or Authy.</p>
                                <p>2. Scan this QR code or add the key manually.</p>
                                <div class="rounded-xl bg-slate-100 p-3 text-center font-mono text-sm tracking-wide dark:bg-navy-700">A3DF-44QX-LM92</div>
                            </div>
                            <button class="btn mt-4 h-10 w-full rounded-full bg-primary text-sm font-semibold text-white hover:bg-primary-focus dark:bg-accent">Enable</button>
                        </div>

                        <div class="rounded-2xl border border-slate-200/70 p-4 dark:border-navy-600">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-500 dark:bg-amber-500/10 dark:text-amber-300">
                                    <i class="fa-solid fa-mobile-screen"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 dark:text-navy-50">Text Message</p>
                                    <p class="text-xs text-slate-400 dark:text-navy-200">Codes will be sent to your phone number.</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-3 text-sm">
                                <label class="block">
                                    <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Phone</span>
                                    <input class="form-input mt-1 w-full rounded-full border border-slate-300 bg-transparent px-4 py-2 text-sm hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="+1 555 000 1122" type="text" />
                                </label>
                                <label class="block">
                                    <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Verify code</span>
                                    <div class="mt-1 flex items-center space-x-2">
                                        <input class="form-input w-full rounded-full border border-slate-300 bg-transparent px-4 py-2 text-center text-lg font-semibold tracking-[0.4em] hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="123456" type="text" />
                                        <button class="btn h-10 rounded-full border border-slate-200 px-4 text-xs font-medium text-slate-600 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-100">Send</button>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
