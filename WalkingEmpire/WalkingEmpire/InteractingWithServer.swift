//
//  InteractingWithServer.swift
//  NBillBoard
//
//  Created by Kedan Li on 14-10-1.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class InteractingWithServer: NSObject {
    
    
    class func getServerAddress() -> String{
        
        return "http://104.236.3.152"
        
    }
    
    class func login()->Bool{
        
        var result:[String: AnyObject] = [String: AnyObject]()
        
        let info :[String: AnyObject] = ["userid": UserInfo.userid, "token": UserInfo.accessToken]
        
        result = InteractingWithServer.connect("/login", info: info)
        return result["success"] as Bool
    }
    
    class func connect(suffix: String ,info:[String: AnyObject])-> [String:AnyObject]{
        
        var result:[String: AnyObject] = [String: AnyObject]()
        
        var request = NSMutableURLRequest(URL: NSURL(string: InteractingWithServer.getServerAddress() + suffix)!, cachePolicy: NSURLRequestCachePolicy.ReloadIgnoringLocalCacheData, timeoutInterval: 5)
        var response: NSURLResponse?
        var error: NSError?
        
        // create some JSON data and configure the request
        var jsonData: NSData = NSJSONSerialization.dataWithJSONObject(info, options: NSJSONWritingOptions.PrettyPrinted, error: &error)!
        
        request.HTTPBody = jsonData//jsonString.dataUsingEncoding(NSUTF8StringEncoding, allowLossyConversion: true)
        request.HTTPMethod = "POST"
        //request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
        
        var returnData:NSData = NSURLConnection.sendSynchronousRequest(request, returningResponse: &response, error: &error)!
        
        if (error == nil){
            
            println(response)
            
            if let httpResponse = response as? NSHTTPURLResponse {
                
                //var returnData = httpResponse.textEncodingName!.dataUsingEncoding(NSUTF8StringEncoding)
                var jsonObject: AnyObject? = NSJSONSerialization.JSONObjectWithData(returnData, options: NSJSONReadingOptions.AllowFragments, error: &error)
                result = jsonObject as [String: AnyObject]!
                
                println(result)
                
                if result["success"] as Bool{
                    
                }else {
                    result.updateValue(false, forKey: "success")
                    result.updateValue(result["comment"] as String, forKey: "error")
                }
            }
        }else{
            result.updateValue(false, forKey: "success")
        }
        return result
    }
    
    class func getCurrentNet() -> String{
        
        var result: String?
        
        let reach = Reachability()
        var internetReachable = Reachability(hostName: "www.apple.com")
        var status: NetworkStatus = internetReachable.currentReachabilityStatus()
        
        println(status.value)
        
        
        if status == 0{
            result = "NO"
        }else if status == 1{
            result = "WIFI"
        }else if status == 2{
            result = "WLAN"
        }
        
        return result!
        
    }
    
    class func getIfConnected() -> Bool{
        
        var result: Bool?
        
        let reach = Reachability()
        var internetReachable = Reachability(hostName: "www.apple.com")
        var status: NetworkStatus = internetReachable.currentReachabilityStatus()
        
        println(status.value)

        
        if status == 0{
            result = false
        }else if status == 1{
            result = true
        }else if status == 2{
            result = true
        }
        
        return result!
        
    }
    
    
    /*
    (NSMutableDictionary*)Login:(NSString *)username password:(NSString *)password
    {
    
    NSError *error1 = [request error];
    if (!error1)
    {
    NSString *response = [request responseString];
    NSLog(@"Test：%@",response);
    NSData* jsonData = [response dataUsingEncoding:NSUTF8StringEncoding];
    id jsonObject = [NSJSONSerialization
    JSONObjectWithData:jsonData options:NSJSONReadingAllowFragments
    error:&error];
    result = (NSMutableDictionary *)jsonObject;
    }
    }
    
    return result;
    
    }
    */
    
}
