from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']


    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
    # query and read
    cypher_query1 = 'MATCH (:Recipes{recipeName:"'+recipe+'"})-[:IS_MADE_OF]-(i:Ingredients) RETURN i.ingredientName as ingreds LIMIT 25'
   
    result = session.run(cypher_query1,{})
    session.close()
    print(recipe)
    print(result)
    results=[]
    ans=""
    print(cypher_query1)
    for record in result:
        item = {'ingredients':record['ingreds']}
        print(record)
        print(record['ingreds'])
        ans+=str(record['ingreds'])+" "
        results.append(item)
    if len(ans)<3:
        response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "I could not find such recipe in here. Would you like to add one?" }   }    }    

    else:
        response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "The ingredients I found for this dish is "+ans+"!" }   }    }    
    return response