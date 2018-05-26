using System;
using System.IO;
using System.Collections.Generic;
using System.Web;
using System.Web.Services;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Linq.Expressions;
using WebMatrix.Data;
using WebMatrix.WebData;

/*
User Manual
 
    //Object Initialisation

    db_object lay_obj= new db_object();
    var result_ret=lay_obj.show_result("NAME SPACE","SELECT * FROM [shop_floor_control_system_db].[dbo].[component_details] where sfcs_shipment_ref="+sfcs_shipment_tid+" and sfcs_component_tid="+sfcs_component_tid);  
    
    foreach(var record in result_ret)
    {
        @record.FIELD NAME;   
    }
*/


public class udf_functions : IDisposable
{

    public string FN_FSP_STATUS_CODE_CELL_BG(string cust_code)
    {
        var msg = "bgcolor=";
        switch(cust_code)
        {
            case "Available":
            {
                msg+="#33FF33";
                break;
            }
            case "50":
            {
                msg+="#FFFF22";
                break;
            }
            case "45":
            {
                msg+="#33CCEE";
                break;
            }
            case "35":
            {
                msg+="#FF66CC";
                break;
            }
            case "20":
            {
                msg+="#CCCCCC";
                break;
            }
            case "10":
            {
                msg+="#CCCCCC";
                break;
            }
            case "Excempted":
            {
                msg+="#99AAEE";
                break;
            }
            case "Not Updated":
            {
                msg+="#99AAEE";
                break;
            }
        }
        return msg;
    }

    public dynamic FN_REM_UPDATE(String BID,String PIH,String REM,int BOMTID,String M3BOMID,String USER)
    {
       try{
            PIH=((PIH=="" || PIH=="NULL")?"NULL":"'"+PIH+"'");
            M3BOMID=((M3BOMID=="" || M3BOMID=="NULL")?"NULL":M3BOMID);

            if(String.IsNullOrEmpty(M3BOMID)  ||  String.IsNullOrWhiteSpace(M3BOMID))
            {
                M3BOMID="99999";
            }

            
            //To update file
            String userData="insert into [BEK_DBS_RMW_0001].[dbo].[T_0001_005_REM_REF] (bom_tid_ref,bom_status,bom_remarks,bom_man_p_ih_date,bom_log_user,m3bompool_tid_ref) values("+BOMTID+",'"+BID+"','"+REM+"',"+PIH+",'"+USER+"',"+M3BOMID+")";
            var dataFile=HttpContext.Current.Server.MapPath("~/App_Data/data.txt");
            File.AppendAllText (@dataFile, userData);
            
            
            db_object db_class=new db_object();
            
            //To update remarks
           db_class.exe_queries("BEK_DBS_RMW_0001","insert into [BEK_DBS_RMW_0001].[dbo].[T_0001_005_REM_REF] (bom_tid_ref,bom_status,bom_remarks,bom_man_p_ih_date,bom_log_user,m3bompool_tid_ref) values("+BOMTID+",'"+BID+"','"+REM+"',"+PIH+",'"+USER+"',"+M3BOMID+")");
                      
           var Linsertid=db_class.last_insert_id();

           DateTime d = DateTime.Now;

           String log_user=USER;
           
           db_class.exe_queries("BEK_DBS_RMW_0001","update [BEK_DBS_RMW_0001].[dbo].[T_0001_004_BOM_POOL] set bom_rem_tid_ref="+Linsertid+",bom_remarks_master='"+REM+"-"+d.ToString("yyyy-MM-dd HH:mm:ss").ToString()+"/"+USER.Replace(@"BRANDIXLK\",@"")+"',bom_man_p_ih_date_master="+PIH+" where bom_tid="+BOMTID);
           
           if(BID=="0")
           {
                var schedule=db_class.show_value("BEK_DBS_RMW_0001","select schedule as value from [BEK_DBS_RMW_0001].[dbo].[V_0001_0005_FR_BOM_TRACK_REP] where bom_tid="+BOMTID);

                db_class.exe_queries("BEK_DBS_RMW_0001","exec [BEK_DBS_RMW_0001].[dbo].[UPDATE_BULK_REM] @schedule_in='"+schedule+"'");
           } 
           
            return false;
        }
         catch(Exception ex){
             throw new Exception (ex.Message);
         }

    }

    public void Dispose()
    {
        GC.SuppressFinalize(this);      
    }

}