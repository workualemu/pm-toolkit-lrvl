<x-base-layout title="Forgot password?">
    <div class="fixed top-0 hidden p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            <img class="h-12 w-12" src="{{ asset('images/app-logo.png') }}" alt="logo" />
            <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ config('app.name') }}
            </p>
        </a>
    </div>
    <div class="w-full lg:grid lg:grid-cols-2 lg:min-h-screen">
       <div class="hidden lg:flex flex-col items-center justify-center p-6">
            <img class="w-full max-w-lg mb-4 mt-4" src="{{ asset('images/illustrations/dashboard-check.svg') }}" alt="image" />
            <div class="text-center px-4">
                <h2 class="text-2xl font-bold text-slate-600 dark:text-navy-100 mb-2">About the Census Project Management System</h2>
                <p class="text-lg text-slate-600 dark:text-navy-100 mx-auto" style="max-width: 600px;">
                    The Census Project Management System simplifies the collection and management of census data with a user-friendly interface for accurate data entry and analysis, supporting collaboration and efficient project management.
                </p>
            </div>
        </div>
        <main class="flex w-full flex-col items-center bg-white dark:bg-navy-700">
            <div class="flex w-full max-w-md grow flex-col justify-center p-12">
                @if (session('status'))
                    <div class="text-center">
                        <img class="mx-auto h-16 w-16 lg:hidden" src="{{ asset('images/app-logo.png') }}" alt="logo" />
                        <div class="mt-4">
                            <p class="text-slate-600 dark:text-navy-300 text-lg">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <img class="mx-auto h-16 w-16 lg:hidden" src="{{ asset('images/app-logo.png') }}" alt="logo" />
                        <div class="mt-4">
                            <h2 class="text-3xl font-semibold text-slate-600 dark:text-navy-100">
                                {{ __('Forgot password?') }}
                            </h2>
                            <p class="text-slate-600 dark:text-navy-300 text-lg">
                                {{ __('Please enter your email address and click on the "Send Password Reset Link" button. An email will be sent to you to reset your password') }}
                            </p>
                        </div>
                    </div>
                    <div class="py-8"></div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @method('POST') @csrf
                        <div class="mb-6">
                            <label for="email" class="block text-slate-600 dark:text-navy-300 mb-2 mr text-lg">{{ __('Email ') }}</label>
                            <div class="relative flex">
                                <input id="email" type="email"
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-4 py-3 pl-11 pr-5 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900 text-lg"
                                    placeholder="" name="email" style="padding: 1rem;" />
                                <span
                                    class="pointer-events-none absolute flex h-full w-12 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-colors duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </div>
                            @error('email')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="btn mt-6 h-12 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 text-lg">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </form>
                @endif
            </div>
            <div class="lg:hidden flex flex-col items-center text-center my-5 text-sm text-slate-400 dark:text-navy-300">
                <span>&copy; 2025 UNECA. All rights reserved.</span>
                <div class="mx-3 my-1 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <a href="#" onclick="toggleModal('termsModal')">Terms of Service</a>
                <div class="mx-3 my-1 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <a href="#" onclick="toggleModal('privacyModal')">Privacy Notice</a>
            </div>
            <div class="hidden lg:flex my-5 justify-center text-sm text-slate-400 dark:text-navy-300">
                <span>&copy; 2025 UNECA. All rights reserved.</span>
                <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <a href="#" onclick="toggleModal('termsModal')">Terms of Service</a>
                <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <a href="#" onclick="toggleModal('privacyModal')">Privacy Notice</a>
            </div>
        </main>
    </div>
  <!-- Terms of Service Modal -->
  <div id="termsModal" class="fixed inset-0 flex items-center justify-center hidden z-50 backdrop-blur-2xl" style="background-color: rgba(0,0,0,0.7);">
        <div class="bg-white dark:bg-navy-700 rounded-lg shadow-lg p-6 w-md max-h-[90vh] overflow-y-auto" style="width: 40vw;">
            <h2 class="text-2xl font-bold text-slate-600 dark:text-navy-100 mb-4 text-center">Terms of Service</h2>
            <div class="text-gray-700 dark:text-navy-100 text-base space-y-3">
                <p><strong>1. Introduction</strong></p>
                <p class="text-justify">Welcome to the Census Project Management System. By accessing or using our services, you agree to be bound by these Terms of Service. Please read them carefully before proceeding.</p>

                <p><strong>2. Definitions</strong></p>
                <ul class="list-disc pl-5" style="margin-left: 1.25em;">
                    <li><strong>"Service"</strong> refers to the Census Project Management System</li>
                    <li><strong>"User"</strong> refers to anyone who accesses or uses the Service</li>
                    <li><strong>"Content"</strong> refers to all data, information, and materials within the Service</li>
                </ul>

                <p><strong>3. Terms of Usage</strong></p>
                <p class="text-justify">Users must ensure that all census data handling complies with relevant data protection regulations and privacy laws. The service must be used solely for authorized census management activities.</p>

                <p><strong>4. Privacy & Data Protection</strong></p>
                <p class="text-justify">All census data collected and processed through our system is subject to strict confidentiality requirements. Users must adhere to data protection protocols and privacy guidelines established by relevant authorities.</p>

                <p><strong>5. Limitation of Liability</strong></p>
                <p class="text-justify">The service is provided "as is" without warranties of any kind. We shall not be liable for any damages arising from the use or inability to use the service.</p>

                <p><strong>6. Termination</strong></p>
                <p class="text-justify">We reserve the right to terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever.</p>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button onclick="toggleModal('termsModal')" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg text-base">Decline</button>
                <button onclick="toggleModal('termsModal')" class="px-4 py-2 text-white bg-blue-600 rounded-lg text-base">Accept Terms</button>
            </div>
        </div>
    </div>

    <!-- Privacy Notice Modal -->
    <div id="privacyModal" class="fixed inset-0 flex items-center justify-center hidden z-50 backdrop-blur-2xl" style="background-color: rgba(0,0,0,0.7);">
        <div class="bg-white dark:bg-navy-700 rounded-lg shadow-lg p-6 w-md max-h-[90vh] overflow-y-auto" style="width: 40vw;">
            <h2 class="text-2xl font-bold text-slate-600 dark:text-navy-100 mb-4 text-center">Privacy Notice</h2>
            <p class="text-gray-700 dark:text-navy-100 text-base">
                <strong>Census Project Management System Privacy Policy</strong><br>
                <span class="text-gray-500">Last updated: January 15, 2025</span>
            </p>
            <p class="text-gray-700 dark:text-navy-100 text-base mt-3 text-justify">
                This privacy notice explains how we collect, use, and protect your personal information when you use our Census Project Management System.
            </p>
            <div class="mt-4 text-gray-700 dark:text-navy-100 text-base">
                <p class="font-semibold">Information We Collect</p>
                <ul class="list-disc pl-5" style="margin-left: 1.25em;">
                    <li>Personal identification information (Name, email address, phone number)</li>
                    <li>Professional information (Job title, department)</li>
                    <li>System usage data and activity logs</li>
                    <li>Census project-related information</li>
                </ul>
            </div>
            <div class="mt-4 text-gray-700 dark:text-navy-100 text-base">
                <p class="font-semibold">How We Use Your Information</p>
                <ul class="list-disc pl-5" style="margin-left: 1.25em;">
                    <li>Project management and coordination</li>
                    <li>Communication with team members</li>
                    <li>System performance monitoring</li>
                    <li>Legal compliance and reporting</li>
                </ul>
            </div>
            <div class="mt-4 text-gray-700 dark:text-navy-100 text-base">
                <p class="font-semibold">Data Protection</p>
                <p class="text-justify">We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
            </div>
            <div class="mt-4 text-gray-700 dark:text-navy-100 text-base">
                <p class="font-semibold">Your Rights</p>
                <p>You have the right to:</p>
                <ul class="list-disc pl-5" style="margin-left: 1.25em;">
                    <li>Access the personal data we hold about you</li>
                    <li>Request the correction of inaccurate data</li>
                    <li>Request the deletion of your data</li>
                    <li>Object to the processing of your data</li>
                </ul>
            </div>
            <div class="flex justify-end items-center mt-6">
                <button onclick="toggleModal('privacyModal')" class="px-4 py-2 text-white bg-blue-600 rounded-lg text-base">I Understand</button>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function acceptTerms() {
            toggleModal('termsModal');
        }

        window.addEventListener("load", () => {
            document.querySelector(".app-preloader").style.display = "none";
        });
    </script>

    <style>
        @media (width: 1024px) and (height: 600px) {
            .lg\:grid {
                display: block !important;
            }

            .hidden.lg\:flex {
                display: none !important;
            }

            .lg\:flex.flex-col {
                display: none !important;
            }
        }
    </style>
</x-base-layout>