<x-app-layout title="User Profile" is-sidebar-open="false" is-header-blur="true" sidebarToggle="false">
    @php
        $twoFactorEnabled = (bool) $user->two_factor_enabled;
        $twoFactorMethod = $user->two_factor_method;
        $recoveryCodes = collect($user->two_factor_recovery_codes ?? []);
        $statusMessages = [
            'profile-updated' => 'Profile updated successfully.',
            'avatar-updated' => 'Profile image updated.',
            'avatar-removed' => 'Profile image removed.',
            'two-factor-enabled' => 'Two-factor authentication enabled.',
            'two-factor-disabled' => 'Two-factor authentication disabled.',
            'two-factor-recovery-codes-regenerated' => 'Backup codes regenerated.',
        ];
        $statusKey = session('status');
        $qrCodeDataUri = $qrCodeDataUri ?? null;
        $displaySecret = $user->two_factor_secret ? trim(chunk_split($user->two_factor_secret, 4, ' ')) : null;
    @endphp
    <main class="main-content w-full px-[var(--margin-x)] pb-8 space-y-4">
        @if ($statusKey)
            <div class="alert flex items-center justify-between rounded-2xl border border-success/50 bg-success/10 px-4 py-3 text-sm text-success">
                <span>{{ $statusMessages[$statusKey] ?? $statusKey }}</span>
                <button class="text-success" onclick="this.closest('div').remove()">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert flex items-center justify-between rounded-2xl border border-error/50 bg-error/10 px-4 py-3 text-sm text-error">
                <span>{{ session('error') }}</span>
                <button class="text-error" onclick="this.closest('div').remove()">&times;</button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert rounded-2xl border border-error/50 bg-error/10 px-4 py-3 text-sm text-error">
                <ul class="list-disc space-y-1 pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between space-y-3 py-2">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-navy-300">Account</p>
                <h2 class="text-xl font-semibold text-slate-800 dark:text-navy-50 lg:text-2xl">Profile &amp; Security</h2>
            </div>
            <div class="flex items-center space-x-3">
                <button class="btn h-10 rounded-full bg-primary px-4 text-xs+ font-medium text-white hover:bg-primary-focus dark:bg-accent" form="profile-details-form" type="submit">
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
                                <img class="rounded-full object-cover" src="{{ $user->profile_photo_url ?? asset('images/200x200.png') }}" alt="avatar" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-navy-50">{{ $user->display_name ?? $user->name }}</h3>
                            <p class="text-sm text-slate-400 dark:text-navy-200">{{ $user->email }}</p>
                        </div>
                        <div class="flex w-full flex-col gap-3 rounded-2xl bg-slate-100/60 p-4 text-left dark:bg-navy-700/70">
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Role</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">{{ optional($user->roles->first())->name ?? 'Member' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Projects</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">{{ $user->projects()->count() }} active</span>
                            </div>
                            <div class="flex items-center justify-between text-xs+">
                                <span class="text-slate-500 dark:text-navy-200">Last Login</span>
                                <span class="font-semibold text-slate-700 dark:text-navy-50">{{ optional($user->last_login_at)?->diffForHumans() ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <form class="mt-6 grid grid-cols-2 gap-3 text-sm" method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <label class="btn flex h-11 cursor-pointer items-center justify-center rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-50">
                            <input type="file" name="profile_photo" class="sr-only" accept="image/*" onchange="this.form.submit()">
                            Upload Avatar
                        </label>
                        <button class="btn h-11 rounded-2xl border border-slate-200 text-slate-600 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-100" name="remove_avatar" value="1" type="submit">
                            Remove
                        </button>
                    </form>
                </div>

                <div class="card p-5">
                    <h3 class="text-base font-semibold text-slate-700 dark:text-navy-50">Security Snapshot</h3>
                    <p class="text-xs+ text-slate-400 dark:text-navy-200">Keep your account protected and up to date.</p>
                    <div class="mt-5 space-y-4">
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-50">Password updated</p>
                                <p class="text-xs text-slate-400 dark:text-navy-200">{{ optional($user->updated_at)?->diffForHumans() ?? 'Unknown' }}</p>
                            </div>
                            <a href="{{ route('password.request') }}" class="btn h-8 rounded-full border border-primary/30 px-3 text-xs text-primary hover:border-primary dark:border-accent/40 dark:text-accent-light">Update</a>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-50">Two-factor status</p>
                                <p class="text-xs text-slate-400 dark:text-navy-200">{{ $twoFactorEnabled ? 'Enabled ('.($twoFactorMethod === 'sms' ? 'SMS' : 'Authenticator').')' : 'Disabled' }}</p>
                            </div>
                            @if ($twoFactorEnabled)
                                <form method="POST" action="{{ route('profile.two-factor.disable') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn h-8 rounded-full border border-error/40 px-3 text-xs text-error hover:bg-error/10" type="submit">Disable</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('profile.two-factor.enable') }}">
                                    @csrf
                                    <input type="hidden" name="method" value="authenticator">
                                    <button class="btn h-8 rounded-full border border-primary/40 px-3 text-xs text-primary hover:bg-primary/10" type="submit">Enable</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-8 space-y-4">
                <form id="profile-details-form" class="card p-5" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Display name</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter name" type="text" name="display_name" value="{{ old('display_name', $user->display_name ?? $user->name) }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-user text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Full name</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter full name" type="text" name="full_name" value="{{ old('full_name', $user->full_name ?? $user->name) }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-user text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Email Address</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter email address" type="email" name="email" value="{{ old('email', $user->email) }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-envelope text-base"></i>
                                </span>
                            </span>
                        </label>
                        <label class="block">
                            <span class="text-xs+ font-medium text-slate-500 dark:text-navy-200">Phone Number</span>
                            <span class="relative mt-1.5 flex">
                                <input class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="+1 555 0123 456" type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" />
                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <div>
                        <h3 class="text-base font-medium text-slate-600 dark:text-navy-100">Linked Accounts</h3>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">Accounts connected to this profile.</p>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12">
                                        <img class="rounded-full" src="{{ asset('images/100x100.png') }}" alt="logo" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-50">Sign in with Google</p>
                                        <p class="text-xs text-slate-400 dark:text-navy-200">Coming soon</p>
                                    </div>
                                </div>
                                <button class="btn h-8 rounded-full border border-slate-200 px-3 text-xs+ font-medium text-primary hover:border-primary hover:bg-primary/10 dark:border-navy-500 dark:text-accent-light" type="button">Connect</button>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 p-3 dark:border-navy-600">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12">
                                        <img class="rounded-full" src="{{ asset('images/100x100.png') }}" alt="logo" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-50">Sign in with Microsoft</p>
                                        <p class="text-xs text-slate-400 dark:text-navy-200">Coming soon</p>
                                    </div>
                                </div>
                                <button class="btn h-8 rounded-full border border-slate-200 px-3 text-xs+ font-medium text-slate-500 dark:border-navy-500 dark:text-navy-200" type="button" disabled>Disconnect</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-primary">Two Factor Authentication</p>
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-navy-50">Add a second layer of security</h3>
                        </div>
                        <label class="inline-flex items-center space-x-2 text-sm font-medium text-slate-600 dark:text-navy-100">
                            <span>Status</span>
                            <input type="checkbox" class="form-switch h-6 w-11 rounded-full border border-slate-300 bg-slate-200 focus:border-primary dark:border-navy-500 dark:bg-navy-600" {{ $twoFactorEnabled ? 'checked' : 'disabled' }} disabled />
                        </label>
                    </div>
                    <p class="mt-2 text-sm text-slate-500 dark:text-navy-200">Use an authenticator app to confirm it is you when you sign in from a new device.</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <form class="rounded-2xl border border-primary/30 p-4" method="POST" action="{{ route('profile.two-factor.enable') }}">
                            @csrf
                            <input type="hidden" name="method" value="authenticator">
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
                                <p>2. Scan this QR code.</p>
                                @if ($qrCodeDataUri && $twoFactorMethod === 'authenticator')
                                    <div class="flex flex-col items-center space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-navy-600 dark:bg-navy-700/60">
                                        <img src="{{ $qrCodeDataUri }}" alt="Authenticator QR code" class="h-40 w-40 rounded-xl border border-slate-200 bg-white p-2 dark:border-navy-500" />
                                        
                                    </div>
                                @else
                                    <div class="rounded-xl bg-slate-100 p-3 text-center text-xs text-slate-500 dark:bg-navy-700 dark:text-navy-200">
                                        Enable two-factor to generate your QR code and secret.
                                    </div>
                                @endif
                            </div>
                            <button class="btn mt-4 h-10 w-full rounded-full bg-primary text-sm font-semibold text-white hover:bg-primary-focus dark:bg-accent" type="submit">{{ $twoFactorEnabled && $twoFactorMethod === 'authenticator' ? 'Reconfigure' : 'Enable' }}</button>
                        </form>
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-200/80 p-4 dark:border-navy-600">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-navy-50">Backup Codes</p>
                                <p class="text-xs text-slate-400 dark:text-navy-200">Store these somewhere safe. Each code can be used once.</p>
                            </div>
                            <form method="POST" action="{{ route('profile.two-factor.regenerate') }}">
                                @csrf
                                <button class="btn h-9 rounded-full border border-slate-200 px-4 text-xs font-medium text-slate-600 hover:border-primary hover:text-primary dark:border-navy-500 dark:text-navy-100" type="submit">Regenerate</button>
                            </form>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3 font-mono text-sm">
                            @forelse ($recoveryCodes as $code)
                                <div class="rounded-xl bg-slate-100 px-3 py-2 text-slate-600 dark:bg-navy-700 dark:text-navy-50">{{ $code }}</div>
                            @empty
                                <p class="col-span-2 text-xs text-slate-400 dark:text-navy-200">No codes yet. Enable two-factor to generate recovery codes.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
