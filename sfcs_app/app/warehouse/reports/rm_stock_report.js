class ReactApp extends React.Component {

    constructor(props) {
        super(props);
        this.reactTable = React.createRef();
        this.state = {
            tableData: [],
            loadingimage: true
        }
    }

    componentDidMount() {
        let url = '/sfcs_app/app/warehouse/reports/rm_stock_report_logic.php';
        axios.get(url, {
            responseType: 'json'
        }).then(response => {
            // let columnsData = [];
            // console.log(response);
            if (response.data.main_data.length) {
              
                this.setState({ tableData: response.data.main_data, loadingimage: false });
            } else {
                swal('Info', 'No Data Found', 'info');
                this.setState({ tableData: [], loadingimage: false });
            }
        }).catch((error) => {
            swal('Error', 'Some thing went wrong, Please try again ' + error, 'error');
            this.setState({ tableData: [], loadingimage: false });
        });


    }

    getExcelData = async () => {
        let allData = '';
        const current = this.reactTable.current;
        let data = [];
        console.log('hii');
        if (current) {
            allData = await current.getResolvedState().sortedData;
            console.log(allData);
        }

        if (allData.length > 0) {
            this.displayExcel(allData);
        } else {
            swal('Please wait until loading is completed');
        }

    }

    displayExcel(data) {
        let headerCol = ["Location", "Lot No", "Style No", "Batch No", "SKU", "Item Description", "Item Name", "Box/Roll No", "Measured Width", "Received Qty", "Issued Qty", "Return Qty", "Balance Qty", "Shade", "Invoice", "Status", "GRN Date", "Remarks", "Label Id", "Product Group", "Buyer", "Supplier"];
        let sheet_data = [];
        const file_name = 'Rm Stock Report.xlsx';
        sheet_data.push(headerCol);
        data.forEach(items => {
            let item = [];
            item.push(items.location, items.lotno, items.style, items.batchno, items.sku, items.itemdescription,
                items.itemname, items.box_roll_no, items.measuredwidth, items.receivedqty, items.issuedqty, items.returnqty,
                items.balanceqty, items.shade, items.invoice, items.status, items.grndate, items.remarks,
                items.labelid, items.productgroup, items.buyer, items.supplier);
            sheet_data.push(item);
        });
        var worksheet = XLSX.utils.aoa_to_sheet(sheet_data);
     
        var workbook = { Sheets: { 'Rm Stock Report': worksheet }, SheetNames: ['Rm Stock Report'] };

        XLSX.writeFile(workbook, file_name);
    }

    render() {
        const tableData = this.state.tableData;
        const loadingimage = this.state.loadingimage;
       
        let colHeadData = [];
        let coldata = {
            columns: [
                {
                    Header: "Location",
                    accessor: "location",
                    filterable: true
                },
                {
                    Header: "Lot No",
                    accessor: "lotno",
                    filterable: true
                },
                {
                    Header: "Style No",
                    accessor: "style",
                    filterable: true
                },
                {
                    Header: "Batch No",
                    accessor: "batchno",
                    filterable: true
                },
                {
                    Header: "SKU",
                    accessor: "sku",
                    filterable: true
                },
                {
                    Header: "Item Description",
                    accessor: "itemdescription",
                    filterable: true
                },
                {
                    Header: "Item Name",
                    accessor: "itemname",
                    filterable: true
                },
                {
                    Header: "Box/Roll No",
                    accessor: "box_roll_no",
                    filterable: true
                },
                {
                    Header: "Measured Width",
                    accessor: "measuredwidth",
                    filterable: true
                },
                {
                    Header: "Received Qty",
                    accessor: "receivedqty",
                    filterable: true
                },
                {
                    Header: "Issued Qty",
                    accessor: "issuedqty",
                    filterable: true
                },
                {
                    Header: "Return Qty",
                    accessor: "returnqty",
                    filterable: true
                },
                {
                    Header: "Balance Qty",
                    accessor: "balanceqty",
                    filterable: true
                },
                {
                    Header: "Shade",
                    accessor: "shade",
                    filterable: true
                },
                {
                    Header: "Invoice",
                    accessor: "invoice",
                    filterable: true
                },
                {
                    Header: "Status",
                    accessor: "status",
                    filterable: true
                },
                {
                    Header: "GRN Date",
                    accessor: "grndate",
                    filterable: true
                },
                {
                    Header: "Remarks",
                    accessor: "remarks",
                    filterable: true
                },
                {
                    Header: "Label Id",
                    accessor: "labelid",
                    filterable: true
                },
                {
                    Header: "Product Group",
                    accessor: "productgroup",
                    filterable: true
                },
                {
                    Header: "Buyer",
                    accessor: "buyer",
                    filterable: true
                },
                {
                    Header: "Supplier",
                    accessor: "supplier",
                    filterable: true
                },
            ]
        };
        colHeadData.push(coldata);

        return (
            <div>
                <div className="panel panel-primary">
                    <div className="panel-heading">RM Stock Report
                    <button type="button" className="btn btn-sm btn-success pull-right" onClick={this.getExcelData}>Export</button>
                    </div>
                    <div className="panel-body">
                        <div className='form-group'>
                            <ReactTable
                                ref={this.reactTable}
                                data={tableData}
                                className='-striped -highlight'
                                columns={colHeadData}
                                loading={loadingimage}
                                defaultPageSize={20}
                                sortable={true}
                                multiSort={true}
                                resizable={true}
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

ReactDOM.render(
    <ReactApp />,
    document.getElementById("app")
);