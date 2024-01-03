import { Component, OnInit } from '@angular/core';
import { VehicleService } from '../service/vehicle.service';

@Component({
  selector: 'app-add-vehicles',
  templateUrl: './add-vehicles.component.html',
  styleUrls: ['./add-vehicles.component.scss']
})
export class AddVehiclesComponent implements OnInit {

  public selectedValue !: string  ;
  public ownerName = '';
  public vehicleType = '';
  public licensePlate = '';

  public vehicles = [];
  public text_success = '';
  public text_validation = '';
  constructor(
    public vehicleService: VehicleService,
  ) {

  }
  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.vehicleService.listVehicles().subscribe((resp:any) => {
      console.log(resp);
      this.vehicles = resp;
    })
  }

  save(){
    this.text_validation = '';
    if(!this.ownerName || !this.licensePlate || !this.vehicleType ){
      this.text_validation = "LOS CAMPOS SON NECESARIOS (ownerName,licensePlate,vehicleType)";
      return;
    }
    console.log(this.selectedValue);

    const formData = new FormData();
    formData.append("owner_name",this.ownerName);
    formData.append("license_plate",this.licensePlate);
    formData.append("vehicle_type",this.vehicleType);


    this.vehicleService.storeVehicle(formData).subscribe((resp:any) => {
      console.log(resp);

      if(resp.message == 403){
        this.text_validation = resp.message_text;
      }else{
        this.text_success = 'El vehículo ha sido registrado correctamente';

        this.ownerName = '';
        this.licensePlate = '';
        this.vehicleType  = '';

      }

    })
  }



}
