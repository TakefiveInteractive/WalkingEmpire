//
//  PostViewController.swift
//  Meeet Up
//
//  Created by Kedan Li on 14/11/18.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class PostViewController: UIViewController {

    @IBOutlet var tag: UIButton!
    @IBOutlet var comments: UIButton!
    @IBOutlet var tagNum: UILabel!
    @IBOutlet var content: UIScrollView!

    var posts = [UIScrollView]()
    
    override func viewDidLoad() {
        super.viewDidLoad()

        tagNum = UILabel(frame: CGRectMake(30, 10, 60, 30))
        tagNum.text = "10"
        tagNum.textAlignment = NSTextAlignment.Left
        tagNum.textColor = UIColor.whiteColor()
        tagNum.font = UIFont(name: "Avenir-Roman", size: 12)
        tag.addSubview(tagNum)
        
        tag.addTarget(self, action: "showTagOptions", forControlEvents: UIControlEvents.TouchUpInside)
        
        let resource = NSBundle.mainBundle().pathForResource("content", ofType: "plist") as String?
        var dict = NSArray(contentsOfFile: resource!) as [[String: AnyObject]]
        
        var scrollerHeight: CGFloat = 0

        for var index = 0; index < dict.count; index++ {
            
            var aPost = UIScrollView(frame: CGRectMake(0, scrollerHeight, 320, 100))
            
            var line = UIImageView(frame: CGRectMake(0, 0, 320, 0.4))
            line.backgroundColor = UIColor.grayColor()
            line.alpha = 0.6
            aPost.addSubview(line)
            
            var heightCount: CGFloat = 10
            
            var name = UILabel(frame: CGRectMake(20, heightCount, 240, 24))
            name.text = dict[index]["user"] as? String
            if name.text == ""{
                name.text = "👻"
            }
            name.textAlignment = NSTextAlignment.Left
            name.textColor = self.view.tintColor
            name.font = UIFont(name: "Avenir-Roman", size: 17)
            aPost.addSubview(name)
            
            var time = UILabel(frame: CGRectMake(260, heightCount, 40, 24))
            time.text = "12:20"
            time.textAlignment = NSTextAlignment.Right
            time.textColor = self.view.tintColor
            time.font = UIFont(name: "Avenir-Roman", size: 13)
            aPost.addSubview(time)
            
            heightCount += 24 + 10
            
            var image = UIImageView(frame: CGRectMake(20, heightCount, 280, 0))
            
            if dict[index]["image"] as? String != ""{
            
                image.image = UIImage(named: dict[index]["image"] as String)
                image.frame = CGRectMake(20, heightCount, 280, 180)
                heightCount += 180 + 10

            }
            aPost.addSubview(image)

            
            var text = UITextView(frame: CGRectMake(20, heightCount, 280,0))
            text.text = dict[index]["content"] as? String
            text.textAlignment = NSTextAlignment.Left
            text.font = UIFont(name: "Avenir-Roman", size: 15)
            text.sizeToFit()
            aPost.addSubview(text)
            
            heightCount += text.frame.height + 10

            var tags: UIButton = UIButton(frame: CGRectMake(20, heightCount, 25, 25))
            tags.setImage(UIImage(named: "tagY"), forState: UIControlState.Normal)
            tags.setImage(UIImage(named: "tagYY"), forState: UIControlState.Selected)
            aPost.addSubview(tags)
            
            var tagN = UILabel(frame: CGRectMake(50, heightCount, 50, 25))
            var num = (dict[index]["comments"] as [AnyObject]).count
            tagN.text = "\(num)"
            tagN.textAlignment = NSTextAlignment.Left
            tagN.textColor = self.view.tintColor
            tagN.font = UIFont(name: "Avenir-Roman", size: 17)
            aPost.addSubview(tagN)
            
            var comments: UIButton = UIButton(frame: CGRectMake(130, heightCount, 25, 25))
            comments.setImage(UIImage(named: "commentsYY"), forState: UIControlState.Normal)
            comments.setImage(UIImage(named: "commentsY"), forState: UIControlState.Selected)
            aPost.addSubview(comments)
            
            var commentsN = UILabel(frame: CGRectMake(160, heightCount, 25, 25))
            commentsN.text = dict[index]["tagnum"] as? String
            commentsN.textAlignment = NSTextAlignment.Left
            commentsN.textColor = self.view.tintColor
            commentsN.font = UIFont(name: "Avenir-Roman", size: 17)
            aPost.addSubview(commentsN)
            
            var like: UIButton = UIButton(frame: CGRectMake(250, heightCount, 25, 25))
            like.setImage(UIImage(named: "likee"), forState: UIControlState.Normal)
            like.setImage(UIImage(named: "like"), forState: UIControlState.Selected)
            like.addTarget(self, action: "chooseLike:", forControlEvents: UIControlEvents.TouchUpInside)
            aPost.addSubview(like)
            
            var likeN = UILabel(frame: CGRectMake(280, heightCount, 25, 25))
            likeN.text = dict[index]["like"] as? String
            likeN.textAlignment = NSTextAlignment.Left
            likeN.textColor = self.view.tintColor
            likeN.font = UIFont(name: "Avenir-Roman", size: 17)
            aPost.addSubview(likeN)
            
            heightCount += 25 + 10

            
            aPost.frame.size = CGSizeMake(320, heightCount)
            aPost.userInteractionEnabled = true
            
            self.content.addSubview(aPost)
            
            scrollerHeight += heightCount
        }

        self.content.contentSize = CGSizeMake(320, scrollerHeight)
        self.content.userInteractionEnabled = true
    }
    
    @IBAction func chooseLike(sender: AnyObject){
        (sender as UIButton).selected = true
    }
    
    override func viewDidAppear(animated: Bool) {
            }

    func showTagOptions(){
        
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
