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
    """
    # query and read
    cypher_query1 = 'MATCH (:Recipe{title:"'+recipe+'"})-[:CONTAINS_INGREDIENT]-(i:Ingredient) RETURN i.value as ingreds LIMIT 25'
    """
    #delete relationship and recipe node
    cypher_query2 ='MATCH (:Recipes{recipeName:"'+recipe+'"})-[r:IS_MADE_OF]-(:Ingredients) DELETE r'
    cypher_query3 ='MATCH (m:Recipes{recipeName:"'+recipe+'"}) DELETE m'

    session.run(cypher_query2,{})
    session.run(cypher_query3,{})
    session.close()
    print(cypher_query2)
    print(cypher_query3)
    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "This recipe record has been deleted" }   }    }    
    return response