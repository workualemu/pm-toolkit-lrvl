import { createGrid } from 'ag-grid-community'; // Correct import for creating the grid
import 'ag-grid-community/styles/ag-theme-alpine.css';

export function initializeAgGrid(gridElementId, columns, rows) {
    const gridOptions = {
        columnDefs: columns,
        rowData: rows,
        defaultColDef: {
            sortable: true,
            filter: true,
            floatingFilter: true,
        },
    };

    const gridDiv = document.querySelector(`#${gridElementId}`);
    createGrid(gridDiv, gridOptions); // Use createGrid to initialize the grid
    console.log('AgGrid.js loaded');
}