from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']

    id = event['currentIntent']['slots']['id']

    value = event['currentIntent']['slots']['value']

    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
 
    #update property of node
    cypher_query4 ='MATCH (m:Recipes{recipeName:"'+recipe+'"}) SET m.'+id+'="'+value+'" RETURN m'
    session.run(cypher_query4,{})
   
    session.close()
    print(cypher_query4)

    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "This record has been updated!" }   }    }    
    return response