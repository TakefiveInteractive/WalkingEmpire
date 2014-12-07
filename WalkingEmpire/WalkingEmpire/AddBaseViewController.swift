//
//  AddBaseViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class AddBaseViewController: UIViewController {

    @IBOutlet var money: UILabel!
    @IBOutlet var close: UIButton!
    @IBOutlet var confirm: UIButton!
    @IBOutlet var tower: UIImageView!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        close.addTarget(self, action: "cancel", forControlEvents: UIControlEvents.TouchUpInside)
        confirm.addTarget(self, action: "buildTheTower", forControlEvents: UIControlEvents.TouchUpInside)
        // Do any additional setup after loading the view.
    }

    func cancel(){
        UIView.animateWithDuration(0.5, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.view.alpha = 0
            self.tower.transform = CGAffineTransformMakeScale(0.5, 0.5)
            
            }
            , completion: {
                (value: Bool) in
                self.view.removeFromSuperview()
                self.removeFromParentViewController()
        })
    }
    
    func buildTheTower(){
        UIView.animateWithDuration(0.5, delay: 0, options: UIViewAnimationOptions.CurveEaseInOut, animations: {
            
            self.view.alpha = 0
            self.tower.transform = CGAffineTransformMakeScale(0.5, 0.5)
            
            }
            , completion: {
                (value: Bool) in
                self.view.removeFromSuperview()
                self.removeFromParentViewController()
        })
        (self.parentViewController as ViewController).build()
        ((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).tempBase.map = ((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).map
        
        
        var result = InteractingWithServer.addBase(((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).tempBase.position)
        //BaseIdentifier upload
        //if result != "failed"{

            ((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).tempBase.identifier = result
            ((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).bases.append(((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).tempBase)
            ((self.parentViewController as ViewController).childViewControllers[0] as MapViewController).tempBase = nil
        //}
        
        
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
