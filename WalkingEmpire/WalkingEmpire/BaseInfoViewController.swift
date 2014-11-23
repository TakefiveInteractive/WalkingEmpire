//
//  BaseInfoViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/23.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class BaseInfoViewController: UIViewController, UIScrollViewDelegate {

    
    @IBOutlet var constructionPanel : UIImageView!
    @IBOutlet var scroller : UIScrollView!
    //@IBOutlet var block : UIButton!
    
    var constructionArea = [[UIButton]]()

    override func viewDidLoad() {
        super.viewDidLoad()
        
        
        
        scroller.scrollEnabled = true;
        scroller.contentSize = CGSizeMake(4, 512);
        
        for var x: Int = 0; x < 8; x++ {
            
            constructionArea.append([UIButton]())
            
            for var y: Int = 0; y < 8; y++ {

            var building = UIButton(frame: CGRectMake(64 * CGFloat(x), 64 * CGFloat(y), 64,64))
                building.setImage(UIImage(named: "ConstructionsPanelSquare"), forState: UIControlState.Normal)
                building.setImage(UIImage(named: "ConstructionsPanelSelectionH"), forState: UIControlState.Highlighted)
                building.addTarget(self, action: "constructionAreaClicked:", forControlEvents: UIControlEvents.TouchUpInside)
                self.scroller.addSubview(building)
                constructionArea[x].append(building)
            }
        }
        
        
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func constructionAreaClicked(sender:UIButton!){
        
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
