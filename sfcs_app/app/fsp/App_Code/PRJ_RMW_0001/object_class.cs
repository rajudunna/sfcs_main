using System;
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


/// <summary>
/// Summary description for ClassName
/// </summary>
public class db_object : IDisposable
{
    int rcount;
    int lastinsertid;
    string result;    
    
    
    //To extract Data Values
    public dynamic show_result(String dbstr,String querystr, int closeconn=0)
    {
        var  db = Database.Open(dbstr); 
                
        //Database Initialisation
        try{
            var selectQueryString = querystr; 
            
            var result_ret=db.Query(selectQueryString);
            rcount=result_ret.Count();
            return result_ret;
         }
         catch(Exception ex){
             //throw new Exception (ex.Message+querystr);
             return null;
         }
         finally{
            if(closeconn==0)
            {
                 db.Close();
            }           
         }         
    }

     //To extract Data Values and to  avoid remote timeout errors
    public dynamic show_result_remote(String dbstr,String querystr, int closeconn=0)
    {
        var  db = Database.Open(dbstr); 
                
        //Database Initialisation
        try{
            var selectQueryString = querystr; 
            
            var result_ret=db.Query(selectQueryString);
            rcount=result_ret.Count();
            return result_ret;
         }
         catch(Exception ex){
             //throw new Exception (ex.Message+querystr);
             return null;
         }
         finally{
            if(closeconn==0)
            {
                 db.Close();
            }           
         }         
    }

    //To display value from executed query
    public dynamic show_value(String dbstr,String querystr, int closeconn=0)
    {
        var  db = Database.Open(dbstr); 
        
        //Database Initialisation
        try{
            var selectQueryString = querystr; 
            
            var result_ret=db.Query(selectQueryString);
            rcount=result_ret.Count();

            //convert it to a List<'a>
            var aList = result_ret.ToList();

            //convert it to a 'a[]
            var anArray = result_ret.ToArray();
            
            if(anArray.Length==0){
                return 0;
            }else{
                if(anArray[0]["value"]==null)
                {
                    return 0;
                } else 
                {
                    return anArray[0]["value"];
                }
                
            }
            
         }
         catch(Exception ex){
             //throw new Exception (ex.Message+querystr);
             return null;
         }
         finally{
            if(closeconn==0)
            {
                 db.Close();
            } 
         }         
    }

    //To Execute Query
    public void exe_queries(String dbstr,String querystr, int closeconn=0)
    {
        var  db = Database.Open(dbstr); 
        

        //Database Initialisation
        try{
            var selectQueryString = querystr;
            db.Execute(selectQueryString);
            
            if(selectQueryString.StartsWith("insert")){
                lastinsertid=(int)db.GetLastInsertId();
                      
            }
         }
         catch(Exception ex){
             //throw new Exception (ex.Message+querystr);
             //return null;
         }
         finally{
            if(closeconn==0)
            {
                 db.Close();
            } 
         }         
    }

    //To Execute Query with bulk insert
    public void exe_queries_bulk(String dbstr,String querystr, int closeconn=0)
    {
        var  db = Database.Open(dbstr); 
        

        //Database Initialisation
        try{
            var selectQueryString = querystr;
            db.Execute(selectQueryString);
         }
         catch(Exception ex){
             //throw new Exception (ex.Message+querystr);
             //return null;
         }
         finally{
            if(closeconn==0)
            {
                 db.Close();
            } 
         }         
    }

    public int queries_count()
    {
        return rcount;
    }

    public int last_insert_id()
    {
        return lastinsertid;
    }

    public void Dispose()
    {
        GC.SuppressFinalize(this);      
    }

}


