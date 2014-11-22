//
//  BuildViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class BuildViewController: UIViewController {

    var builds:[String] = ["base","tower","mine","lumber","petrol"]

    var buttons:[String:UIButton] = [String:UIButton]()
    
    var selectedButton: String = ""
    
    @IBOutlet var container: UIScrollView!

    override func viewDidLoad() {
        super.viewDidLoad()

        for var index = 0; index < builds.count ; index++ {
            
            var but: UIButton = UIButton(frame: CGRectMake(CGFloat(index) * 70, 0, 70, 70))
            but.addTarget(self, action: "buildingChosen:", forControlEvents: UIControlEvents.TouchUpInside)
            but.setTitle(builds[index], forState: UIControlState.Normal)
            but.setTitle("selected", forState: UIControlState.Selected)
            but.backgroundColor = UIColor.blackColor()
            self.container.addSubview(but)
            buttons.updateValue(but, forKey: builds[index])
        }
        
        container.contentSize = CGSizeMake(70 * CGFloat(builds.count), 70)
        
        // Do any additional setup after loading the view.
    }

    @IBAction func buildingChosen(sender: UIButton){
        
        if selectedButton != ""{
            buttons[selectedButton]?.selected = false
        }
        selectedButton = sender.titleLabel!.text!
        sender.selected = true
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
