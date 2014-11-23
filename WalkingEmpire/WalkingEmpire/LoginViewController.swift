//
//  LoginViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class LoginViewController: UIViewController, FBLoginViewDelegate{
    
    var theLoginView:FBLoginView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        theLoginView = FBLoginView(frame: CGRectMake(0, 0, 230, 80))
        theLoginView.center = self.view.center
        theLoginView.center.y = theLoginView.center.y + 20
        self.view.addSubview(theLoginView)
        
        theLoginView.delegate = self
        theLoginView.readPermissions = ["public_profile", "email", "user_friends"]
        // Do any additional setup after loading the view.
    }
    
    func loginViewFetchedUserInfo(loginView: FBLoginView!, user: FBGraphUser!) {
        
        UserInfo.name = user.name
        UserInfo.userid = user.objectID
        UserInfo.accessToken = FBSession.activeSession().accessTokenData.accessToken
        UserInfo.upadateUserInfo()
        InteractingWithServer.login()
        println(user.name)
        println(user.objectID)

        /*
        var url: NSURL = NSURL.URLWithString("https://graph.facebook.com/(user.objectID)/picture?type=normal")
        var data: NSData = NSData.dataWithContentsOfURL(url, options: nil, error: nil)
        
        FBRequestConnection.startWithGraphPath("/me/picture", parameters: nil, HTTPMethod: "GET", completionHandler: {(connection: FBRequestConnection!, result: AnyObject!, error: NSError!) -> Void in
            if (result? != nil) {
                //var jsonFeeds = result as FBGraphObject
                println("@@@@@@")
                println(result)
               // self.feeds = self.buildFeeds((jsonFeeds["feed"] as FBGraphObject)["data"] as NSMutableArray)
                
            }
            } as FBRequestHandler)
        */
    }
    func loginViewShowingLoggedInUser(loginView: FBLoginView!) {
        (self.parentViewController as ViewController).removeLoginView()
    }
    func loginViewShowingLoggedOutUser(loginView: FBLoginView!) {
        
    }
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    /*
    // MARK: - Navigation
    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
    // Get the new view controller using segue.destinationViewController.
    // Pass the selected object to the new view controller.
    }
    */
    
}
