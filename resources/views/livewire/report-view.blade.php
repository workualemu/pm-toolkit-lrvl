<div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <div>
        <div
            class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
        >
            <select wire:model.defer="viewFormat" 
                class="form-select mt-1.5 w-32 rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
            >
                <option selected>HTML</option>
                <option>PDF</option>
            </select>
            <div class="flex justify-center space-x-2">
                <button wire:click="showPDF()"
                    class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                >
                    Excel
                </button>
            </div>
        </div>


        <div class="card mt-3">
            <div
                class="min-w-full overflow-x-auto"
                x-data="pages.tables.initExample1"
            >
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            @foreach($columns AS $index=>$item)
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{$item->title}}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results AS $index=>$res)
                            <tr 
                                class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                            > 
                                @foreach($columns AS $col)                      
                                    <td
                                        class="whitespace-nowrap px-3 py-1 font-medium text-slate-700 dark:text-navy-100 lg:px-5"
                                    >
                                        {{ $res[$col->db_column] }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>