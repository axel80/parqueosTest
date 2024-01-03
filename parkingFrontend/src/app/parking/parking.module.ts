import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ParkingComponent } from './parking.component';
import { SharedModule } from '../shared/shared.module';
import { ParkingRoutingModule } from './parking-routing.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { RouterModule } from '@angular/router';

@NgModule({
  declarations: [
    ParkingComponent,

    //HeaderComponent,
    //SidebarComponent

  ],
  imports: [
    CommonModule,
    ParkingRoutingModule,
    SharedModule,
    //
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    RouterModule
  ]
})
export class ParkingModule { }
