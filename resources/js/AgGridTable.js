import { createGrid, ModuleRegistry } from 'ag-grid-community';
import { ColumnAutoSizeModule } from 'ag-grid-community'; 
import { ClientSideRowModelModule } from 'ag-grid-community';
import { NumberFilterModule, TextFilterModule, DateFilterModule} from 'ag-grid-community';

ModuleRegistry.registerModules([ClientSideRowModelModule, ColumnAutoSizeModule,
    NumberFilterModule, TextFilterModule, DateFilterModule
]);
export default class AgGridTable {
    id;
    rootElement;
    table;
    options;

    constructor(htmlId) {
        this.id = htmlId
        this.api = null;
        this.gridReady = false;
        this.rootElement = document.getElementById(htmlId)
        this.rootElement.classList.add(...['ag-theme-quartz', 'w-full', 'h-[calc(60vh)]']);

        this.options = JSON.parse(this.rootElement.dataset['options'])

        this.options.columnTypes = {
            textColumn: {
                filter: "agTextColumnFilter",
                floatingFilter: true,
                sortable: true,
                width: 200
            },
            numericColumn: {
                filter: "agNumberColumnFilter",
                floatingFilter: true,
                sortable: true,
                width: 150,
                valueFormatter: params => params.value ? new Intl.NumberFormat().format(params.value) : ''
            },
            dateColumn: {
                filter: "agDateColumnFilter",
                floatingFilter: true,
                sortable: true,
                width: 15
            },
            rangeColumn: {
                width: 150,
                filter: "agNumberColumnFilter",
                comparator: (valueA, valueB) => {
                    const numA = parseFloat(valueA) || 0;
                    const numB = parseFloat(valueB) || 0;
                    return numA - numB;
                }
            }
        };

        this.options.onGridReady = params => {
            this.api = params.api;
            this.columnApi = params.columnApi;
            this.gridReady = true;
        };
        
        if (this.options?.rowData?.length > 0) {
            this.rootElement.innerHTML = ''
            this.table = createGrid(this.rootElement, this.options)
        }

        // console.log(this.options);
        // this.registerLivewireEventListeners();
    }

    registerLivewireEventListeners() {
        alert('1');
        Livewire.on(`updateTable.${this.id}`, (event) => {
            let options;
            alert('2');
            [options] = event;
            console.log('Table received data: ' + this.id, options);
            this.rootElement.innerHTML = '';
    
            options.defaultColDef = {
                sortable: true,
                filter: true, // Enable filtering for all columns
                floatingFilter: true, // Make filters visible in the header
            };
            
            options.columnTypes = {
                textColumn: {
                    filter: "agDateColumnFilter",
                    floatingFilter: true,
                    sortable: true,
                    width: 200
                },
                numericColumn: {
                    filter: "agNumberColumnFilter",
                    floatingFilter: true,
                    sortable: true,
                    width: 150,
                    valueFormatter: params => params.value ? new Intl.NumberFormat().format(params.value) : ''
                },
                dateColumn: {
                    filter: "agDateColumnFilter",
                    floatingFilter: true,
                    sortable: true,
                    width: 150,
                    valueFormatter: params => params.value ? new Intl.NumberFormat().format(params.value) : ''
                },
                rangeColumn: {
                    width: 150,
                    filter: "agNumberColumnFilter",
                    comparator: (valueA, valueB) => {
                        const numA = parseFloat(valueA) || 0;
                        const numB = parseFloat(valueB) || 0;
                        return numA - numB;
                    }
                }
            };
            
            options.columnDefs = options.columnDefs.map(colDef => {
                if (colDef?.type === 'numericColumn') {
                    colDef.filter = "agNumberColumnFilter";  // Ensure numbers can be filtered
                    colDef.valueFormatter = params => new Intl.NumberFormat().format(params.value);
                }
                if (colDef?.type === 'textColumn') {
                    colDef.filter = "agTextColumnFilter";  // Ensure text columns have filters
                }
                if (colDef?.type === 'rangeColumn') {
                    colDef.filter = "agNumberColumnFilter"; // Allow range filtering
                    colDef.comparator = (valueA, valueB) => {
                        const numA = parseFloat(valueA) || 0;
                        const numB = parseFloat(valueB) || 0;
                        return numA - numB;
                    };
                }
                if (!colDef.type) {
                    if (colDef.field === "title" || colDef.field === "status") {
                        colDef.type = "textColumn";
                    } else if (colDef.field === "Start Date" || colDef.field === "End Date") {
                        colDef.type = "rangeColumn"; // Or use a date column type if preferred
                    } else {
                        colDef.type = "numericColumn";
                    }
                }

                return colDef;
            });
            
            this.table = createGrid(this.rootElement, options);
        });
    }

    resize() {
        const table = Alpine.raw(this.table)
        if (table) {
            table.sizeColumnsToFit()
        }
    }

    // onBtExportCSV() {
    //     gridOptions.api.exportDataAsCsv({
    //         fileName: 'my_grid_data.csv'
    //     });
    // }

    exportToExcel() {
        alert('1');

        if (!gridOptions.api) {
            alert('Grid API not initialized!');
            return;
        }
        
        gridOptions.api.exportDataAsCsv({
            fileName: 'my_grid_data.csv'
        });
        alert('2');
    }
}
