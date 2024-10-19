@extends('master')
@section('title','table eleve')
@section('content')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row mt-5">

            <div class="col-lg-12 grid-margin mt-4 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">infos sur eleve </h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead class="table-info">
                        <tr>
                          <th>
                            Id
                          <th>
                            nom
                          </th>
                          <th>
                            prenom
                          </th>
                          <th>
                            date_naissance
                          </th>
                          <th>
                            classe
                          </th>
                          <th>
                            adress
                          </th>
                          <th>
                            annee_scolaire
                          </th>
                          <th>
                            agent d'enregistrement
                          </th>
                        </tr>
                      </thead>
                      <tbody class="table table-dark">
                        <tr>
                          <td>
                            
                          </td>
                          <td>
                            
                          </td>
                          <td>
                           
                          </td>
                          <td>
                            
                          </td>
                          <td>
                            
                          </td>
                          <td>
                            
                          </td>
                          <td>
                            
                          </td>
                          <td>
                            
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@include('partials.footer')

@endsection