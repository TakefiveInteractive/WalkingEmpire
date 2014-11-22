
//
//  MoneyResourcePopulation.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

var MoneyResoursePopulationManager: MoneyResourcePopulation = MoneyResourcePopulation()

class MoneyResourcePopulation: NSObject {
    var money: Int = 0
    var population: Int = 0
    var resources: Int = 0
    
    func setValues(moneyy: Int, populations: Int, resource: Int){
        money = moneyy
        population = populations
        resources = resource
    }
    
    func addValue(distance: Double){
        money = money + Int(distance)
        population = population + Int(distance) * 3
        resources = resources + Int(distance) * 2
    }
}
