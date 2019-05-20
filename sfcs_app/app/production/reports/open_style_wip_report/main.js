class ReactApp extends React.Component {
    constructor(props) {
        super(props);
        this.reactTable = React.createRef(); 		
        this.state = {
            columnsData: [],
            tableData: [],
            loadingimage:true  
        }		
    }    
				
    componentDidMount () {     
        let url = '/sfcs_app/app/production/reports/open_style_wip_report/report_logic.php';
        axios.get(url, {
            responseType: 'json'
        }).then(response => {
            let columnsData = [];
            if(response.data.operations.length >0 && response.data.main_data.length){
                if(response.data.operations.length>0){       
                    response.data.operations.forEach(val=>{
                        columnsData.push(val);
                    });            
                }
                this.setState({ tableData: response.data.main_data,columnsData:columnsData,loadingimage:false});
            }else{ 
                this.setState({ tableData:[],columnsData:[],loadingimage:false});
            }          
        }) .catch((error) => {
            swal('Error','Some thing went wrong, Please try again '+error,'error'); 
			this.setState({ tableData:[],columnsData:[],loadingimage:false});
        }); 
		
		
    }
	
	getExcelData = async () =>
    {
		let allData = '';
        const current = this.reactTable.current; 
        let data = [];
		console.log('hii');
        if(current){            
            allData =  await current.getResolvedState().sortedData; 
			console.log(allData);
        }

        if(allData.length>0){
            this.displayExcel(allData);
        }else{
		    swal('Please wait until loading is completed');
		}
        
    }

    displayExcel(data){
		
        let dynamicColumns = this.state.columnsData;
		//let mainHeader = ["","","","","Good","","","","","","","Rejected","","","","","","","WIP"];
		let mainHeader = ["","","","","","Good"];
        let headerCol = ["Style","Customer Order No","Schedule","Color","Size"];
        let sheet_data = [];        
        const file_name = 'Open Style Wip Report.xlsx';
        const operations = ['good','rej','wip']; // A hardcoded array,Change this in accordance with the keys getting from php file 
        
		operations.forEach(ignore=>{
		    dynamicColumns.forEach(vals=>{
			    headerCol.push(vals.op_name);
		    });
		});
		
		var count = dynamicColumns.length;
		var display = count - 1;
		for (var i = 0; i < display; i++) {
          mainHeader.push("");
        }
		mainHeader.push("Rejected");
		for (var i = 0; i < display; i++) {
          mainHeader.push("");
        }
		mainHeader.push("WIP");
		sheet_data.push(mainHeader);
		sheet_data.push(headerCol);
		console.log('checkcount= '+display);
		console.log('count= '+count);
		var main =5;
		
		var merge  = { s: {r:0, c:main }, e: {r:0, c:main + display} };
		var merge1 = { s: {r:0, c:main + display + 1}, e: {r:0, c:main + display + display + 1} };
		var merge2 = { s: {r:0, c:main + display + display + 2}, e: {r:0, c:main + display + display + display + 1} };
		
		
		
        data.forEach(items=>{
            let newKeys = [];
            let keys = Object.keys(items);
			
			operations.forEach(op=>{
            dynamicColumns.forEach(vals=>{ 
					keys.forEach(res=>{ 
                        if(op+''+vals.op_code == res){
                            newKeys.push(op+''+vals.op_code);
							//newKeys[vals.op_code] = op+''+vals.op_code;
                        }
                    });
				})
            });
			//newKeys.sort();
			console.log(newKeys);
			
            let item = [];
            item.push(items.style,items.cono,items.schedule,items.color,items.size);
            if(newKeys.length>0){                
                newKeys.forEach(res=>{
                    let op_val = 0;
                    if(items[res]){
                        op_val = items[res];
                    }
                    item.push(op_val);  
                })      
                sheet_data.push(item);         
            }            
        });
        var worksheet = XLSX.utils.aoa_to_sheet(sheet_data);
		worksheet['!merges'] = [];
		worksheet['!merges'].push(merge,merge1,merge2);
		console.log(worksheet);
        // worksheet.mergeCells('E1:K1');
        var workbook = {Sheets: {'Open Style Wip Report': worksheet}, SheetNames: ['Open Style Wip Report']};
		
        XLSX.writeFile(workbook, file_name);  
    }
				
    render() {   
	    const tableData = this.state.tableData;        
        const dynamicColumns = this.state.columnsData;  
        const loadingimage = this.state.loadingimage; 

     let colHeadData = [];
     let collistData1 = [];
     let collistData2 = [];
     let collistData3 = [];
	 let coltotaldata = [];
	 
		
        let coldata = {
			//Header: "Total:",
            columns: [
                {
                    Header: "Style",
                    accessor: "style",
                    filterable:true
                },
				{
                    Header: "Customer Order No",
                    accessor: "cono",
                    filterable:true
                },
                {
                    Header: "Schedule",
                    accessor: "schedule",
                    filterable:true
                },
                {
                    Header: "Color",
                    accessor: "color",
                    filterable:true
                },
                {
                    Header: "Size",
                    accessor: "size",
                    filterable:true
                },
                {
                    Header: "Order Quantity",
                    accessor: "orderqty",
                    filterable:true
                },				
            ]
        };
        colHeadData.push(coldata);
		
		
		//to get good,rej,wip
        dynamicColumns.forEach(val=>{
            let goodcolumns = {
                Header: val.op_name,
			    //headerClassName: 'green',
                accessor: 'good'+val.op_code,
                filterable:false,
			    //className:'green'
             }
			let rejcolumns = {
                Header: val.op_name,
                accessor: 'rej'+val.op_code,
                filterable:false,
			    //className:'red'
                }
		    let wipcolumns = {
                Header: val.op_name,
                accessor: 'wip'+val.op_code,
                filterable:false,
			    //className:'yellow'
            }
				
            collistData1.push(goodcolumns);
            collistData2.push(rejcolumns);	
            collistData3.push(wipcolumns);
        })
		
	
		let collist1 = {
            Header: "Operation Reported Qty(Good)",
			columns : collistData1,
			className:'green'
		}
		let collist2 = {
            Header: "Operation Reported Qty(Rejections)",
			columns: collistData2,
			className:'red'
		}
		let collist3 = {
            Header: "WIP",
			columns: collistData3,
			className:'yellow'
		}
		
		colHeadData.push(collist1);
		colHeadData.push(collist2);
		colHeadData.push(collist3);

		//console.log(tableData);
        return (
            <div> 
                <div className="panel panel-primary">
                    <div className="panel-heading">Style Wip Report 
                    <button type="button" className="btn btn-sm btn-success pull-right" onClick={this.getExcelData}>Export</button>
					</div>
                    <div className="panel-body">
                        <div className='form-group'>
                            <ReactTable
                                ref={this.reactTable}
                                data={tableData}
                                className='-striped -highlight'
								
                                columns={coltotaldata,colHeadData}
                                loading={loadingimage}
                                defaultPageSize={20}
                                sortable= {true}
                                multiSort= {true}
                                resizable= {true}
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