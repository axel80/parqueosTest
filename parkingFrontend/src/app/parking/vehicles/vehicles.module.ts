import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { VehiclesRoutingModule } from './vehicles-routing.module';
import { VehiclesComponent } from './vehicles.component';
import { AddVehiclesComponent } from './add-vehicles/add-vehicles.component';
import { EditVehiclesComponent } from './edit-vehicles/edit-vehicles.component';
import { ListVehiclesComponent } from './list-vehicles/list-vehicles.component';


@NgModule({
  declarations: [
    VehiclesComponent,
    AddVehiclesComponent,
    EditVehiclesComponent,
    ListVehiclesComponent
  ],
  imports: [
    CommonModule,
    VehiclesRoutingModule
  ]
})
export class VehiclesModule { }
