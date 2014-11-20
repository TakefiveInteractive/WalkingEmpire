//
//  ViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/20.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit


class ViewController: UIViewController, GMSMapViewDelegate {

    var map: GMSMapView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        var camera: GMSCameraPosition = GMSCameraPosition.cameraWithLatitude(-33.86, longitude: 151.23, zoom:6)
        
        map = GMSMapView.mapWithFrame(CGRectZero, camera: camera)
        map.myLocationEnabled = true
        self.view = map
        
        var marker = GMSMarker(position: CLLocationCoordinate2DMake(-33.86, 151.20))
        marker.title = "sdfds"
        marker.snippet = "sdfdssddssdf"
        marker.map = map

        
        
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func viewDidAppear(animated: Bool) {


    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

