import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ICity } from '../interfaces/city';
import { ICountry } from '../interfaces/country';
import { IState } from '../interfaces/state';

@Injectable({
  providedIn: 'root'
})
export class AddressService {

  constructor(private http:HttpClient) {}

  getCities() : Observable<ICity[]>{
    return this.http.get<ICity[]>(`${environment.API_SERVER_URL}/city.php`);
  }
  getState() : Observable<IState[]>{
    return this.http.get<IState[]>(`${environment.API_SERVER_URL}/state.php`);
  }
  getCountry() : Observable<ICountry[]>{
    return this.http.get<ICountry[]>(`${environment.API_SERVER_URL}/country.php`);
  }
}
