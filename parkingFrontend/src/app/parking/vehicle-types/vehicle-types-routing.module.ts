import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { VehicleTypesComponent } from './vehicle-types.component';
import { AddVehicleTypesComponent } from './add-vehicle-types/add-vehicle-types.component';
import { ListVehicleTypesComponent } from './list-vehicle-types/list-vehicle-types.component';

const routes: Routes = [
  {
    path:'',
    component:VehicleTypesComponent,
    children:[
      {
        path:'register',
        component:AddVehicleTypesComponent
      },
      {
        path:'list',
        component:ListVehicleTypesComponent
      },

    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class VehicleTypesRoutingModule { }
