//
//  ViewController.swift
//  meet up
//
//  Created by Kedan Li on 14/11/18.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class ViewController: UIViewController, UITabBarDelegate {
    
    @IBOutlet var tabbar: UITabBar!
    
    @IBOutlet var home: UIView!
    @IBOutlet var people: UIView!
    @IBOutlet var selfme: UIView!
    @IBOutlet var chats: UIView!

    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    func tabBar(tabBar: UITabBar, didSelectItem item: UITabBarItem!) {
        presentView(item.title!)
    }
    
    func presentView(title: String){
        
        if title == "Home"{
            presentHome()
        }else if title == "Chats"{
            presentChats()
        }else if title == "People"{
            presentPeople()
        }else if title == "Me"{
            presentSelf()
        }
    }
    
    func presentHome(){
        UIView.animateWithDuration(0.4, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.home.alpha = 1
            self.people.alpha = 0
            self.selfme.alpha = 0
            self.chats.alpha = 0
            
            }
            , completion: {
                (value: Bool) in
        })
    }
    func presentSelf(){
        UIView.animateWithDuration(0.4, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.home.alpha = 0
            self.people.alpha = 0
            self.selfme.alpha = 1
            self.chats.alpha = 0
            
            }
            , completion: {
                (value: Bool) in
        })
    }
    func presentChats(){
        UIView.animateWithDuration(0.4, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.home.alpha = 0
            self.people.alpha = 0
            self.selfme.alpha = 0
            self.chats.alpha = 1
            
            }
            , completion: {
                (value: Bool) in
        })
    }
    func presentPeople(){
        UIView.animateWithDuration(0.4, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.home.alpha = 0
            self.people.alpha = 1
            self.selfme.alpha = 0
            self.chats.alpha = 0
            
            }
            , completion: {
                (value: Bool) in
        })
    }


}

