import { HttpClient, HttpHandler, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { URL_SERVICES } from 'src/app/config/config';
import { AuthService } from 'src/app/shared/auth/auth.service';

@Injectable({
  providedIn: 'root'
})
export class VehicleTypesService {

  constructor(
    public http:HttpClient,
    public authService: AuthService,
    ) { }

    listVehicleTypes(){
      const headers = new HttpHeaders({'Authorization':'Bearer '+this.authService.token});
      const URL = URL_SERVICES+"/catalogs/vehicle-types";
      return this.http.get(URL,{headers: headers});
    }
}
