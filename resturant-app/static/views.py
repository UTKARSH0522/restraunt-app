
import requests
from django.http import JsonResponse

def get_restaurant_data(request, restaurant_id):

    url = f'http://localhost:8080/restaurant_api.php?id={restaurant_id}'
    response = requests.get(url)
    data = response.json()
    return JsonResponse(data)

def create_restaurant(request):
    url = 'http://ocalhost:8080/restaurant_api.php'
    data = {
        'name': request.POST.get('name'),
        'description': request.POST.get('description')
    }
    response = requests.post(url, data=data)
    data = response.json()
    return JsonResponse(data)

def update_restaurant(request, restaurant_id):
    url = f'http://ocalhost:8080/restaurant_api.php'
    data = {
        'id': restaurant_id,
        'name': request.POST.get('name'),
        'description': request.POST.get('description')
    }
    response = requests.put(url, data=data)
    data = response.json()
    return JsonResponse(data)

def delete_restaurant(request, restaurant_id):
    url = f'http://ocalhost:8080/restaurant_api.php'
    data = {
        'id': restaurant_id
    }
    response = requests.delete(url, data=data)
    data = response.json()
    return JsonResponse(data)
