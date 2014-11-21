//
//  MapViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/20.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

import MapKit

class MapViewController: UIViewController {

    @IBOutlet var map: MKMapView!

    let latitude = 42.0534
    let longitude = -87.672
    
    override func viewDidLoad() {
        super.viewDidLoad()

        initializeGameMap()

        // Do any additional setup after loading the view.
    }

    func initializeGameMap(){
        let span = MKCoordinateSpanMake(0.0005, 0.0005)
        let region = MKCoordinateRegion(center: CLLocationCoordinate2DMake(latitude, longitude), span: span)
        map.setRegion(region, animated: true)
        
        //3
        let annotation = MKPointAnnotation()
        annotation.setCoordinate(CLLocationCoordinate2DMake(latitude, longitude))
        annotation.title = "Big Ben"
        annotation.subtitle = "London"
        map.addAnnotation(annotation)
        
        addOverlay()

    }

    func addOverlay(){
        var overlay: MKOverlayView = MKOverlayView(frame: CGRectMake(0, 0, 100, 100))
        overlay.backgroundColor = UIColor.redColor()
        map.addOverlay(overlay, level: MKOverlayLevel.AboveLabels)
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
