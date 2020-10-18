class ReactApp extends React.Component {
    constructor(props) {
        super(props);  
        this.reactTable = React.createRef();      
        let mm1;
        let dd1;
        let today = new Date();
        let dd = today.getDate();     
        let mm = today.getMonth()+1; 
        let yyyy = today.getFullYear();
        if(dd.toString().length<2){
            dd1 = "0"+dd;
        }else{
            dd1 = dd;
        }
        if(mm.toString().length<2){
            mm1 = "0"+mm;
        }else{
            mm1 = mm;
        }
        let currentDate = yyyy+'-'+mm1+'-'+dd1;
        this.state = {
            columnsData: [],
            tableData: [],
            date: currentDate,
            loadingimage:true,
        }
        this.currentDate = currentDate;
        var url_string = window.location.href; //window.location.href
        var url = new URL(url_string);
        this.plant_code = url.searchParams.get("plantCode");
        this.getData(event);

        // alert(c);s
    }    
				
    componentDidMount () {
        
    }
    getData = (event)=>{
        this.setState({loadingimage:true});
        let value = event.target.value;
        if(value){
            value = event.target.value;
        }else{
            value = this.currentDate;
        }
        let url = '/sfcs_app/app/production/reports/daily_performance/apicalls.php/getData?date='+value+'&plant='+ this.plant_code;
        axios.get(url, {
            responseType: 'json'
        }).then(response => {
            let columnsData = [];
            if(response.data.columns.length >0 && response.data.data.length){
                if(response.data.columns.length>0){       
                    response.data.columns.forEach(val=>{
                        columnsData.push(val);
                    });            
                }
                this.setState({ tableData: response.data.data,columnsData:columnsData,loadingimage:false,mainData:response.data.data});
            }else{ 
                this.setState({ tableData:[],columnsData:[],loadingimage:false});
            }
            
        }) .catch((error) => {
            swal('Error','Some thing went wrong, Please try again '+error,'error');     
            this.setState({ tableData: [],columnsData:[],loadingimage:false});
        }); 
    }
  

    getExcelData = () =>
    {
        const current = this.reactTable.current; 
        let data = [];
        if (current){            
            const allData = current.getResolvedState().sortedData; 
            allData.forEach(element => {
                element._subRows.forEach(elem1=>{
                    elem1._subRows.forEach(elem2=>{
                        elem2._subRows.forEach(function(elem3){
                            elem3._subRows.forEach(elem4=>{
                                data.push(elem4);
                            });                            
                        })
                    })
                });
            });          
        }

        if(data.length>0){
            this.displayExcel(data);
        }else{
		    swal('Please wait until loading is completed');
		}
        
    }

    displayExcel(data){
        let dynamicColumns = this.state.columnsData;
        let headerCol = ["Style","Schedule","Color","Size"];
        let sheet_data = [];        
        const file_name = 'Daily Performance Report'+'-'+this.currentDate+'.xlsx';
        dynamicColumns.forEach(val=>{
            headerCol.push(val.op_name);
        });

        sheet_data.push(headerCol);
         
        data.forEach(items=>{
            let newKeys = [];
            let keys = Object.keys(items);
            dynamicColumns.forEach(vals=>{ 
			console.log('vals');
			console.log(vals);
                keys.forEach(res=>{
                    console.log('res');
                    console.log(res);					
                    if(vals.op_code == res){
                        newKeys.push(vals.op_code);
                    }
                });
            });
            let item = [];
            item.push(items.style,items.schedule,items.color,items.size);
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

        const workbook = {Sheets: {'Daily Performance Report': worksheet}, SheetNames: ['Daily Performance Report']};
        XLSX.writeFile(workbook, file_name);  
    }
   
						
    render() {
        const tableData = this.state.tableData;        
        const dynamicColumns = this.state.columnsData;  
        const loadingimage = this.state.loadingimage;   

        let colHeadData = [];
        let coldata = {
            Header: "Total:",
            columns: [
                {
                    Header: "Style",
                    accessor: "style",
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
            ]
            };
        colHeadData.push(coldata);

        dynamicColumns.forEach(val=>{
            let collist = {
                Header:()=>{
                    let colSum = 0;
                    for (let i = 0; i <= tableData.length; i++) {                        
                        if(tableData[i]){
                            if(val.op_code == Object.keys(tableData[i])[0]){
                                if(tableData[i][Object.keys(tableData[i])[0]]){
                                    colSum+=tableData[i][Object.keys(tableData[i])[0]];
                                }
                            }
                        }                                            
                    }
                   return  (<span style={{ float: "right" }}>{colSum}</span>)
                },
                columns:[{
                    Header: val.op_name,
                    accessor: val.op_code,
                    filterable:false,
                    aggregate: (values, rows) => _.sum(values),
                    Aggregated: row => {
                    return (
                        <span style={{
                            float: "right"
                          }}>
                        {(row.value)?row.value:'0'}
                        </span>
                    );
                    },
                }]
            }
            colHeadData.push(collist);
        })

        return (
            <div> 
                <div className="panel panel-primary">
                    <div className="panel-heading">Daily Performance Report</div>
                    <div className="panel-body">
                        <form className="form-inline" >
                            <div className="form-group">
                                <label htmlFor="date">Date:</label>
                                <input type="date" className="form-control" id="date" defaultValue={this.state.date} onChange={(event)=>this.getData(event)}/>
                            </div>
                            <button type="button" className="btn btn-primary pull-right" onClick={this.getExcelData}>Export</button>
                        </form>                                                                                     

                        <div className='form-group'>
                            <ReactTable
                                ref={this.reactTable}
                                data={tableData}
                                className='-striped -highlight'
                                columns={colHeadData}
                                loading={loadingimage}
                                defaultPageSize={20}
                                pivotBy={["style","schedule","color","size"]}
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