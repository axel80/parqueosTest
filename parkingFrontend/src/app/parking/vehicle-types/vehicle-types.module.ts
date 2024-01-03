import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { VehicleTypesRoutingModule } from './vehicle-types-routing.module';
import { VehicleTypesComponent } from './vehicle-types.component';
import { AddVehicleTypesComponent } from './add-vehicle-types/add-vehicle-types.component';
import { EditVehicleTypesComponent } from './edit-vehicle-types/edit-vehicle-types.component';
import { ListVehicleTypesComponent } from './list-vehicle-types/list-vehicle-types.component';


@NgModule({
  declarations: [
    VehicleTypesComponent,
    AddVehicleTypesComponent,
    EditVehicleTypesComponent,
    ListVehicleTypesComponent
  ],
  imports: [
    CommonModule,
    VehicleTypesRoutingModule
  ]
})
export class VehicleTypesModule { }
