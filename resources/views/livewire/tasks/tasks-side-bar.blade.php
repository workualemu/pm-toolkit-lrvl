<div class="flex h-[calc(100%-4.5rem)] grow flex-col">
    <div class="is-scrollbar-hidden grow overflow-y-auto">
        <div class="mt-2 px-4">
            
        </div>
        <ul class="mt-5 space-y-1.5 px-2 font-inter font-medium">
            <li>
                <a class="cursor-pointer group flex {{ $bgMyAssigned }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myAssignedTasks()">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><defs><style>.a,.b{fill:none;stroke:#000000;stroke-linecap:round;stroke-width:1.5px;}.a{stroke-linejoin:round;}.b{stroke-linejoin:bevel;}</style></defs><path class="a" d="M3,21.016l.78984-2.87249C5.0964,13.3918,8.5482,11.016,12,11.016"/><circle class="b" cx="12" cy="5.98404" r="5"/><circle class="a" cx="17" cy="18" r="5"/><polyline class="a" points="14.872 18.149 16.32 20.082 19.533 16.572"/></svg>
                    <span>{{ __('My assigned tasks') }}</span>
                </a>
            </li>
            <!--
            <li>
                <a class="cursor-pointer group flex {{ $bgMyCommented }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myCommentedTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    <span>{{ __('My commented tasks') }}</span>
                </a>
            </li>
-->
            <li>
                <a class="cursor-pointer group flex {{ $bgMyReporting }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myReportingTasks()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M15 11L15 17" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 12L12 17" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M9 14L9 17" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M17.8284 6.82843C18.4065 7.40649 18.6955 7.69552 18.8478 8.06306C19 8.4306 19 8.83935 19 9.65685L19 17C19 18.8856 19 19.8284 18.4142 20.4142C17.8284 21 16.8856 21 15 21H9C7.11438 21 6.17157 21 5.58579 20.4142C5 19.8284 5 18.8856 5 17L5 7C5 5.11438 5 4.17157 5.58579 3.58579C6.17157 3 7.11438 3 9 3H12.3431C13.1606 3 13.5694 3 13.9369 3.15224C14.3045 3.30448 14.5935 3.59351 15.1716 4.17157L17.8284 6.82843Z" stroke="#323232" stroke-width="2" stroke-linejoin="round"/>
</svg>
                    <span>{{ __('My reporting tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="cursor-pointer group flex {{ $bgStarred }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="starredTasks()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    <span>{{ __('Starred tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="cursor-pointer group flex space-x-2 rounded-lg {{ $bgAll }} p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="allTasks()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14 16L16.1 18.5L20 13.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 14H3" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M10 18H3" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M3 6L13.5 6M20 6L17.75 6" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M20 10L9.5 10M3 10H5.25" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
</svg>
                    <span>{{ __('All tasks') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
