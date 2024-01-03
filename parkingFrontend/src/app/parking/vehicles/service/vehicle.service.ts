import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { URL_SERVICES } from 'src/app/config/config';
import { AuthService } from 'src/app/shared/auth/auth.service';

@Injectable({
  providedIn: 'root'
})
export class VehicleService {

  constructor(
    public http:HttpClient,
    public authService: AuthService,
  ) { }

  listVehicles(){
    const headers = new HttpHeaders({'Authorization':'Bearer '+this.authService.token});
    const URL = URL_SERVICES+"/catalogs/vehicles";
    return this.http.get(URL,{headers: headers});
  }

  storeVehicle(data:any){
    const headers = new HttpHeaders({'Authorization': 'Bearer '+this.authService.token});
    const URL = URL_SERVICES+"/catalogs/vehicles";
    return this.http.post(URL,data,{headers: headers});
  }

  editRoles(data:any,id:any){
    const headers = new HttpHeaders({'Authorization': 'Bearer '+this.authService.token});
    const URL = URL_SERVICES+"/catalogs/vehicles/"+id;
    return this.http.put(URL,data,{headers: headers});
  }

  deleteRoles(id:any){
    const headers = new HttpHeaders({'Authorization': 'Bearer '+this.authService.token});
    const URL = URL_SERVICES+"/catalogs/vehicles/"+id;
    return this.http.delete(URL,{headers: headers});
  }
}
