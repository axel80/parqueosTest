import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ParkingComponent } from './parking.component';
import { AuthGuard } from '../shared/gaurd/auth.guard';

const routes: Routes = [
  {
    path:'',
    component:ParkingComponent,
    canActivate:[AuthGuard],
    children:[
      {
        path: 'vehicle-types',
        loadChildren: () =>
          import('./vehicle-types/vehicle-types.module').then((m) => m.VehicleTypesModule),
      },

      {
        path: 'vehicles',
        loadChildren: () =>
          import('./vehicles/vehicles.module').then((m) => m.VehiclesModule),
      },


    ]

  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ParkingRoutingModule { }
