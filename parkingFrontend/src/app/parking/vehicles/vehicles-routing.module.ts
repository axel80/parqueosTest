import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { VehiclesComponent } from './vehicles.component';
import { AddVehiclesComponent } from './add-vehicles/add-vehicles.component';
import { ListVehiclesComponent } from './list-vehicles/list-vehicles.component';
import { EditVehiclesComponent } from './edit-vehicles/edit-vehicles.component';

const routes: Routes = [
  {
    path:'',
    component:VehiclesComponent,
    children:[
      {
        path:'register',
        component:AddVehiclesComponent
      },

      {
        path:'list',
        component:ListVehiclesComponent
      },

      {
        path:'edit',
        component:EditVehiclesComponent
      },


    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class VehiclesRoutingModule { }
