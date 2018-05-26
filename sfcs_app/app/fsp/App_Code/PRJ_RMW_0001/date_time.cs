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



    public static class MyExtensionMethods
    {
        public static DateTime AddBusinessDays(this DateTime date, int days)
        {
	        double sign = Convert.ToDouble(Math.Sign(days));
            int unsignedDays = Math.Sign(days) * days;
            for (int i = 0; i < unsignedDays; i++)
            {
                do
                {
                    date = date.AddDays(sign);
                }
                /*while (date.DayOfWeek == DayOfWeek.Saturday || 
                    date.DayOfWeek == DayOfWeek.Sunday);*/
                while (date.DayOfWeek == DayOfWeek.Sunday);
            }
            return date;
        }       
    }

