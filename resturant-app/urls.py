# restaurantapp/urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('restaurant/<int:restaurant_id>/', views.get_restaurant_data, name='get-restaurant-data'),
    path('restaurant/create/', views.create_restaurant, name='create-restaurant'),
    path('restaurant/<int:restaurant_id>/update/', views.update_restaurant, name='update-restaurant'),
    path('restaurant/<int:restaurant_id>/delete/', views.delete_restaurant, name='delete-restaurant'),
    path('admin/', admin.site.urls),
    path('api/', include('restaurantapp.urls')), 
]


