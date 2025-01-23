import { createGrid, ModuleRegistry } from 'ag-grid-community';
import { ColumnAutoSizeModule } from 'ag-grid-community'; 
import { ClientSideRowModelModule } from 'ag-grid-community';
ModuleRegistry.registerModules([ClientSideRowModelModule, ColumnAutoSizeModule]);
export default class AgGridTable {
    id;
    rootElement;
    table;
    options;

    constructor(htmlId) {
        this.id = htmlId
        this.rootElement = document.getElementById(htmlId)
        this.rootElement.classList.add(...['ag-theme-quartz', 'w-full', 'h-[calc(60vh)]']);
        const vizId = this.rootElement.getAttribute('viz-id')

        
        this.options = JSON.parse(this.rootElement.dataset['options'])
        if (this.options?.rowData?.length > 0) {
            this.rootElement.innerHTML = ''
            this.table = createGrid(this.rootElement, this.options)
        }


        console.log({htmlId, options: this.options})
        this.registerLivewireEventListeners();
    }

    registerLivewireEventListeners() {
        Livewire.on(`updateTable.${this.id}`, (event) => {
            let options
            [options] = event
            console.log('Table received data: ' + this.id, options);
            this.rootElement.innerHTML = ''

            options.columnDefs = options.columnDefs.map(colDef => {
                /*if (colDef?.type === 'numericColumn') {
                    colDef.valueFormatter = params => new Intl.NumberFormat().format(params.value)
                }*/
                if (colDef?.type === 'rangeColumn') {
                    colDef.comparator = (valueA, valueB, nodeA, nodeB, isDescending) => parseInt(valueA) - parseInt(valueB)
                }
                return colDef
            })

            // options.getRowStyle = params => {
            //     let path = params.api.getValue("path", params.node)
            //     let matches = path.match(/\./g);
            //     let numMatches = matches ? matches.length : 0;
            //     if (numMatches == 0) {
            //         return { background: 'rgb(56 189 248)' };
            //     } else if (numMatches == 1) {
            //         return { background: 'rgb(186 230 253)' };
            //     }else {
            //         return { background: 'rgb(240 249 255)' };
            //     }
            // },

            this.table = createGrid(this.rootElement, options);
        });
    }

    resize() {
        const table = Alpine.raw(this.table)
        if (table) {
            table.sizeColumnsToFit()
        }
    }
}
