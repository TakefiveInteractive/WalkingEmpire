//
//  ViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/20.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit


class ViewController: UIViewController {

    var loginView : LoginViewController!
    var confirmView : AddBaseViewController!
    var baseInfo : BaseInfoViewController!

    @IBOutlet var buildButton: UIButton!
    @IBOutlet var relocateButton: UIButton!
    @IBOutlet var menuButton: UIButton!

    var generals: [String: General] = [String: General]()
    var buildings: [String: Base] = [String: Base]()
    
    override func viewDidLoad() {
        super.viewDidLoad()

        buildButton.addTarget(self, action: "build", forControlEvents: UIControlEvents.TouchUpInside)
        menuButton.addTarget(self, action: "menu", forControlEvents: UIControlEvents.TouchUpInside)
        relocateButton.addTarget(self, action: "relocate", forControlEvents: UIControlEvents.TouchUpInside)

        
        if UserInfo.isLogined(){
            
            if InteractingWithServer.checkCookie(){
                LocationInfo.start()
            }else{
                
                UserInfo.logout()
                LocationInfo.location.stopUpdatingLocation()
                loginView = self.storyboard!.instantiateViewControllerWithIdentifier("login")! as LoginViewController
                displayLoginController(loginView)
                
                UIView.animateWithDuration(0.3, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
                        self.loginView.view.alpha = 1
                    }
                    , completion: {
                        (value: Bool) in
                })
                
            }
        }else{
            
            loginView = self.storyboard!.instantiateViewControllerWithIdentifier("login")! as LoginViewController
            displayLoginController(loginView)
            UIView.animateWithDuration(0.3, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
                    self.loginView.view.alpha = 1
                }
                , completion: {
                    (value: Bool) in
            })
        }

        // Do any additional setup after loading the view, typically from a nib.
    }
    
    func displayBaseInfo(){
        baseInfo = self.storyboard!.instantiateViewControllerWithIdentifier("baseInfo")! as BaseInfoViewController
        displayLoginController(baseInfo)
        UIView.animateWithDuration(0.3, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            self.baseInfo.view.alpha = 1
            }
            , completion: {
                (value: Bool) in
        })

    }
    
    func build(){
        if buildButton.selected{
            buildButton.selected = false
            (self.childViewControllers[0] as MapViewController).constructionOverlay.map = nil
            (self.childViewControllers[0] as MapViewController).constructionOverlay = nil

        }else{
            buildButton.selected = true
            (self.childViewControllers[0] as MapViewController).resetPosition()
            (self.childViewControllers[0] as MapViewController).setUpOverlay()

        }
    }
    
    func buildBaseConfirm(){
        confirmView = self.storyboard!.instantiateViewControllerWithIdentifier("confirmBase")! as AddBaseViewController
        displayLoginController(confirmView)
        UIView.animateWithDuration(0.3, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.confirmView.view.alpha = 1
            
            }
            , completion: {
                (value: Bool) in
        })
    }
    
    func menu(){
        
    }
    
    func relocate(){
        (self.childViewControllers[0] as MapViewController).resetPosition()
    }
    
    func displayLoginController(content: UIViewController){
        self.addChildViewController(content)
        content.didMoveToParentViewController(self)          // 3
        content.view.alpha = 0
        self.view.addSubview(content.view)
    }
    
    func hideContentController(content: UIViewController){
        content.view.removeFromSuperview()
        content.removeFromParentViewController()
    }
    
    func removeLoginView(){
        LocationInfo.start()
        UIView.animateWithDuration(0.5, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.loginView.view.alpha = 0
            
            }
            , completion: {
                (value: Bool) in
                self.hideContentController(self.loginView)
                LocationInfo.start()
        })
    }
    
    override func viewDidAppear(animated: Bool) {


    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

