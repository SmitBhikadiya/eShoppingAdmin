import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ServicetaxService {

  constructor(private http:HttpClient) { }

  getTaxByState(countryId:any, stateId:any){
    return this.http.get<any>(`${environment.API_SERVER_URL}/servicetax.php?countryId=${countryId}&stateId=${stateId}`);
  }
}
