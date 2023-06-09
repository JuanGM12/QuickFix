<body class="app"> 
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <div class="row g-3 mb-4 align-items-center justify-content-between">
				    <div class="col-auto">
			            <h1 class="app-page-title mb-0">Mis Servicios</h1>
				    </div>
				    <div class="col-auto">
					     <div class="page-utilities">
						    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
							    <div class="col-auto">
								    <form class="table-search-form row gx-1 align-items-center">
					                    <div class="col-auto">
					                        <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Buscar">
					                    </div>
					                    <div class="col-auto">
					                        <button type="submit" class="btn app-btn-secondary">Buscar</button>
					                    </div>
					                </form>
					                
							    </div><!--//col-->
							    <div class="col-auto">
								    
								    <select class="form-select w-auto" >
										  <option selected value="option-1">Todos</option>
										  <option value="option-2">Esta semana</option>
										  <option value="option-3">Este mes</option>
										  <option value="option-4">Últimos 3 meses</option>
										  
									</select>
							    </div>
						    </div><!--//row-->
					    </div><!--//table-utilities-->
				    </div><!--//col-auto-->
			    </div><!--//row-->
			   
			    
			    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
				    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Todos</a>
				    <a class="flex-sm-fill text-sm-center nav-link"  id="orders-paid-tab" data-bs-toggle="tab" href="#orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">Terminados</a>
				    <a class="flex-sm-fill text-sm-center nav-link" id="orders-pending-tab" data-bs-toggle="tab" href="#orders-pending" role="tab" aria-controls="orders-pending" aria-selected="false">Pendientes</a>
				    <a class="flex-sm-fill text-sm-center nav-link" id="orders-cancelled-tab" data-bs-toggle="tab" href="#orders-cancelled" role="tab" aria-controls="orders-cancelled" aria-selected="false">Cancelados</a>
				</nav>
				
				
				<div class="tab-content" id="orders-table-tab-content">
			        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
					    <div class="app-card app-card-orders-table shadow-sm mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
							        <table class="table app-table-hover mb-0 text-left">
										<thead>
											<tr>
												<th class="cell"># Orden</th>
												<th class="cell">Servicio</th>
												<th class="cell">Cliente</th>
												<th class="cell">Fecha</th>
												<th class="cell">Estado</th>
												<th class="cell">Total</th>
												<th class="cell"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="cell">#1</td>
												<td class="cell"><span class="truncate">Mecánico a domicilio</span></td>
												<td class="cell">John Sanders</td>
												<td class="cell"><span>17 Oct</span><span class="note">2:16 PM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$259.350</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
											<tr>
												<td class="cell">#2</td>
												<td class="cell"><span class="truncate">Reparación mecánica</span></td>
												<td class="cell">Dylan Ambrose</td>
												<td class="cell"><span class="cell-data">16 Oct</span><span class="note">03:16 AM</span></td>
												<td class="cell"><span class="badge bg-warning">Pendiente</span></td>
												<td class="cell">$96.200</td>
												<!-- <td class="cell"><a class="btn-sm app-btn-secondary" href="#">Aceptar</a></td> -->
											</tr>
											<tr>
												<td class="cell">#3</td>
												<td class="cell"><span class="truncate">Reparación eléctrica</span></td>
												<td class="cell">Teresa Holland</td>
												<td class="cell"><span class="cell-data">16 Oct</span><span class="note">01:16 AM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$123.000</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
											
											<tr>
												<td class="cell">#4</td>
												<td class="cell"><span class="truncate">Alineación de rueda</span></td>
												<td class="cell">Jayden Massey</td>
												<td class="cell"><span class="cell-data">15 Oct</span><span class="note">8:07 PM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$199.000</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
											
											<tr>
												<td class="cell">#5</td>
												<td class="cell"><span class="truncate">Balanceo de rueda</span></td>
												<td class="cell">Reina Brooks</td>
												<td class="cell"><span class="cell-data">12 Oct</span><span class="note">04:23 PM</span></td>
												<td class="cell"><span class="badge bg-danger">Cancelado</span></td>
												<td class="cell">$59.000</td>
												<!-- <td class="cell"><a class="btn-sm app-btn-secondary" href="#">Ver más</a></td> -->
											</tr>
											
											<tr>
												<td class="cell">#6</td>
												<td class="cell"><span class="truncate">Diágnostico general</span></td>
												<td class="cell">Raymond Atkins</td>
												<td class="cell"><span class="cell-data">11 Oct</span><span class="note">11:18 AM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$678.260</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
		
										</tbody>
									</table>
						        </div><!--//table-responsive-->
						       
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->
						<nav class="app-pagination">
							<ul class="pagination justify-content-center">
								<li class="page-item disabled">
									<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
							    </li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
								    <a class="page-link" href="#">Siguiente</a>
								</li>
							</ul>
						</nav><!--//app-pagination-->
						
			        </div><!--//tab-pane-->
			        
			        <div class="tab-pane fade" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
					    <div class="app-card app-card-orders-table mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
								    
							        <table class="table mb-0 text-left">
										<thead>
											<tr>
												<th class="cell"># Orden</th>
												<th class="cell">Servicio</th>
												<th class="cell">Cliente</th>
												<th class="cell">Fecha</th>
												<th class="cell">Estado</th>
												<th class="cell">Total</th>
												<th class="cell"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="cell">#1</td>
												<td class="cell"><span class="truncate">Mecánico a domicilio</span></td>
												<td class="cell">John Sanders</td>
												<td class="cell"><span>17 Oct</span><span class="note">2:16 PM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$259.350</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
											
											<tr>
												<td class="cell">#3</td>
												<td class="cell"><span class="truncate">Reparación eléctrica</span></td>
												<td class="cell">Teresa Holland</td>
												<td class="cell"><span class="cell-data">16 Oct</span><span class="note">01:16 AM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$123.000</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
											
											<tr>
												<td class="cell">#4</td>
												<td class="cell"><span class="truncate">Alineación de rueda</span></td>
												<td class="cell">Jayden Massey</td>
												<td class="cell"><span class="cell-data">15 Oct</span><span class="note">8:07 PM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$199.000</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
										
											
											<tr>
												<td class="cell">#6</td>
												<td class="cell"><span class="truncate">Diágnostico general</span></td>
												<td class="cell">Raymond Atkins</td>
												<td class="cell"><span class="cell-data">11 Oct</span><span class="note">11:18 AM</span></td>
												<td class="cell"><span class="badge bg-success">Terminado</span></td>
												<td class="cell">$678.260</td>
												<td class="cell"><a class="btn-sm app-btn-secondary" href="calificar">Calificar</a></td>
											</tr>
		
										</tbody>
									</table>
						        </div><!--//table-responsive-->
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->
			        </div><!--//tab-pane-->
			        
			        <div class="tab-pane fade" id="orders-pending" role="tabpanel" aria-labelledby="orders-pending-tab">
					    <div class="app-card app-card-orders-table mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
							        <table class="table mb-0 text-left">
										<thead>
										<tr>
												<th class="cell"># Orden</th>
												<th class="cell">Servicio</th>
												<th class="cell">Cliente</th>
												<th class="cell">Fecha</th>
												<th class="cell">Estado</th>
												<th class="cell">Total</th>
												<th class="cell"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="cell">#2</td>
												<td class="cell"><span class="truncate">Reparación mecánica</span></td>
												<td class="cell">Dylan Ambrose</td>
												<td class="cell"><span class="cell-data">16 Oct</span><span class="note">03:16 AM</span></td>
												<td class="cell"><span class="badge bg-warning">Pendiente</span></td>
												<td class="cell">$96.200</td>
												<!-- <td class="cell"><a class="btn-sm app-btn-secondary" href="#">Ver más</a></td> -->
											</tr>
										</tbody>
									</table>
						        </div><!--//table-responsive-->
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->
			        </div><!--//tab-pane-->
			        <div class="tab-pane fade" id="orders-cancelled" role="tabpanel" aria-labelledby="orders-cancelled-tab">
					    <div class="app-card app-card-orders-table mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
							        <table class="table mb-0 text-left">
										<thead>
											<tr>
												<th class="cell"># Orden</th>
												<th class="cell">Servicio</th>
												<th class="cell">Cliente</th>
												<th class="cell">Fecha</th>
												<th class="cell">Estado</th>
												<th class="cell">Total</th>
												<th class="cell"></th>
											</tr>
										</thead>
										<tbody>
											
											<tr>
												<td class="cell">#5</td>
												<td class="cell"><span class="truncate">Balanceo de rueda</span></td>
												<td class="cell">Reina Brooks</td>
												<td class="cell"><span class="cell-data">12 Oct</span><span class="note">04:23 PM</span></td>
												<td class="cell"><span class="badge bg-danger">Cancelado</span></td>
												<td class="cell">$59.000</td>
												<!-- <td class="cell"><a class="btn-sm app-btn-secondary" href="#">Ver más</a></td> -->
											</tr>
											
										</tbody>
									</table>
						        </div><!--//table-responsive-->
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->
			        </div><!--//tab-pane-->
				</div><!--//tab-content-->
		    </div>
	    </div>
    </div>   					
</body>


